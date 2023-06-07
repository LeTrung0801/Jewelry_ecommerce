<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Components\Util;

use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptDetail;

use App\Http\Services\ProductService;
use App\Http\Services\SupplierService;
use App\Models\Supplier;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

// use App\Http\Services\CategoryService;
// use App\Http\Services\CollectionService;

// use DB;
// use File;
// use App\Http\Helpers\AppData;

// use App\Http\Requests\ProductRequest;

class WareHouseController extends Controller
{
    private $proService;
    private $supService;

    public function __construct(ProductService $proService, SupplierService $supplier)
    {
        $this->proService = $proService;
        $this->supService = $supplier;
    }

    public function list (Request $request){

        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            $list = Receipt::orderBy('rep_id','desc')->get();
            return view('admin.warehouse.list',[
                'list' => $list
            ]);
        }else{
            return redirect()->route('admin-home')->with([
               'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function add(Request $request){
        $inputs = $request->all();
        $pro_ids = array();
        foreach($inputs as $key => $value){
            array_push($pro_ids,$key);
        }
        if(!empty($pro_ids)){
            $products = Product::whereIn('pro_id',$pro_ids)->get();
        }

        foreach($products as $item){
            $pro = Session::get('pro');
            $pro[$item->pro_id] = [
                'id' => $item->pro_id,
                'name' => $item->pro_name,
                'price' => 0,
                'qty' => 0,
            ];
            Session::put('pro', $pro);
        }
        return redirect()->back();
    }

    public function create (Request $request){
        $suppliers = $this->supService->getList();
        return view ('admin.warehouse.create')->with([
            'supplier' => $suppliers,
        ]);
    }

    public function save (Request $request){
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $inputs = $request->all();
        $receipt_id = date('Ymdhis', time());
        $staff = Auth::guard('admin')->user();

        for($i = 0; $i < count($inputs['pro']); $i++){
            $data = [
                'rep_id' => $receipt_id,
                'pro_id' => $inputs['pro'][$i]['id'],
                'quantity' => $inputs['pro'][$i]['qty'],
            ];
            $bill_data = ReceiptDetail::create($data);
        }

        $bill= [
            'rep_id' => $receipt_id,
            'sup_id' => $inputs['sup_id'],
            'acc_id' => $staff->acc_id,
        ];
        $bill_summary = Receipt::create($bill);
        Session::forget('pro');
        return redirect()->route('admin-warehouse-list')->with([
            'message' => 'done',
        ]);
    }

    public function edit($pk){
        $staff = Auth::guard('admin')->user();
        if(!empty($pk)){
            $bill_summary = Receipt::where('rep_id',$pk)->first();
            $bill_detail = ReceiptDetail::where('rep_id',$pk)->get();

            $supplier = Supplier::where('sup_id',$bill_summary->sup_id)->first();
            $sup_name = $supplier->sup_name;
            if(!empty($bill_detail)){
                $bill_data = $bill_detail->toArray();
                $inputs = [
                    'rep_id' => $pk,
                    'bill_data' =>  $bill_data,
                ];
                // dd($inputs);
                return view('admin.warehouse.edit',[
                    'input' => $inputs,
                    'bill_summary' => $bill_summary,
                    'supplier' => $sup_name,
                ]);
            }
        }
    }

    public function update(Request $request, $pk){
        $inputs = $request->all();
        $staff = Auth::guard('admin')->user();

        $bill_summary = Receipt::where('rep_id',$pk)->first();
        $total = 0;
        for($i = 0; $i < count($inputs['data']); $i++){
            $total += $inputs['data'][$i]['price']*$inputs['data'][$i]['quantity'];
            $data = [
                'price' => $inputs['data'][$i]['price'],
                'quantity' => $inputs['data'][$i]['quantity'],
                'total_price' => $inputs['data'][$i]['price']*$inputs['data'][$i]['quantity'],
            ];
            $bill_data = ReceiptDetail::where('rep_id',$pk)->where('pro_id',$inputs['data'][$i]['pro_id']);
            $bill_data->update($data);

            $product = Product::find($inputs['data'][$i]['pro_id']);
            $pro_price = $inputs['data'][$i]['price']*1.4;
            settype($pro_price,"integer");
                $data_pro = [
                    'pro_price' => $pro_price,
                    'pro_qty' => $product->pro_qty + $inputs['data'][$i]['quantity'],
                    'pro_status' => 0,
            ];
            $product->update($data_pro);
        }

        $bill= [
            'total' => $total,
            'rep_status' => 1,
            'acc_id' => $staff->acc_id,
        ];
        $bill_summary->update($bill);

        return redirect()->route('admin-warehouse-list')->with([
            'message' => 'done',
        ]);
    }

    public function delete($pk){
        $pro = Session::get('pro');
        if(isset($pro[$pk])){
            unset($pro[$pk]);
        }
        Session::put('pro', $pro);
        if(empty($pro)){
            Session::forget('pro');
        }
        return redirect()->back();
    }

}
