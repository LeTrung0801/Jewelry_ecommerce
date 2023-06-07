<?php

namespace App\Http\Controllers;
use App\Http\Services\OrderService;
use App\Http\Services\OrderDetailService;
use App\Http\Services\ProductService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\OrderRequest;

use DB;

use App\Models\City;
use App\Models\District;
use App\Models\OrderDetail;
use App\Models\Ward;

class OrderController extends Controller
{
    private $orderService;
    private $orderDetailService;

    private $productService;

    public function __construct(OrderService $orders,OrderDetailService $detail, ProductService $product)
    {
        $this->orderService = $orders;
        $this->orderDetailService = $detail;
        $this->productService = $product;
    }

    public function list(Request $request, Order $order){
        $keyword = $request->keyword;
        $condition = [
			'o_status' => 0,
            'keyword' => $keyword
		];
		$options = [
            'get' => true,
        ];
        $list = $this->orderService->repository()->search($condition, $options);
        return view('admin.order.list',[
            'list' => $list,
        ]);
    }

    public function list_s1(Order $order){
        $condition = [
			'o_status' => 2,
		];
		$options = [
            'get' => true,
        ];
        $list_s1 = $this->orderService->repository()->search($condition, $options);
        return view('admin.order.list_s1',[
            'list_s1' => $list_s1,
        ]);
    }

    public function list_s2(Order $order){
        $condition = [
			'o_status' => 3,
		];
		$options = [
            'get' => true,
        ];
        $list_s2 = $this->orderService->repository()->search($condition, $options);
        return view('admin.order.list_s2',[
            'list_s2' => $list_s2,
        ]);
    }

    public function getDetail(Request $request, $pk){
        // dd($request->all());
        $detail = OrderDetail::where('o_id',$pk)->get();
        // dd($detail);
        return view('user.pages.my-order-detail',[
            'detail' => $detail,
        ]);
    }

    public function status(Request $request){
        $o_id = $request->id;
        $condition = [
			'order' => $o_id,
		];
		$options = [
            'get' => true,
        ];
        $order = $this->orderService->repository()->findByPk($o_id);
            $count = 0;
            $order_detail = $this->orderDetailService->repository()->search($condition,$options);
        DB::beginTransaction();
        try {
            foreach ($order_detail as $item){
                $pro = $this->productService->repository()->findByPk($item->pro_id);
                if($item->quantity > $pro->pro_qty){
                    DB::rollback();
                    $result = 0;
                    break;
                }else{
                    $qt = $pro->pro_qty-$item->quantity;
                    $pro->update(['pro_qty' => $qt]);
                    if($qt == 0){
                        $pro->update(['pro_status' => 1]);
                    }
                    $count++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
        }
        if($count == count($order_detail) && $order->o_status == 0){
            $order->update(['o_status' => 1]);
            $result = 1;
        }
        return response()->json($result);
    }

    public function delete($pk){
        $order = $this->orderService->repository()->findByPk($pk);
        if($order->o_status == 0){
            $order->update(['o_status' => 3]);
            session()->flash('message', 'done');
        }else{
            session()->flash('errorMessage', 'error');
        }

        return response()->json();
    }

    public function store(OrderRequest $request){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $inputs = $request->all();

        //set order value
        DB::beginTransaction();
        try {
            if (empty($inputs['address']) && empty($inputs['address1'])) {
                $address = $inputs['cus_add'];
            } elseif (!empty($inputs['address1'])){
                $city = City::find($inputs['city1']);
                $district = District::find($inputs['district1']);
                $ward = Ward::find($inputs['ward1']);
                $address = $inputs['address1'].', '.$ward->name.', '.$district->name.', '.$city->name;
            } else {
                $city = City::find($inputs['city']);
                $district = District::find($inputs['district']);
                $ward = Ward::find($inputs['ward']);
                $address = $inputs['address'].', '.$ward->name.', '.$district->name.', '.$city->name;
            }
            $id = Auth::guard('cus')->user()->cus_id;

            $order_id = date('Ymdhis', time()).$id;
            //get order detail value, get total
            $total = 0;
            $product = Session::get('cart');
            //save order detail
            DB::enableQueryLog();
            foreach($product as $item){
                $total = $total + $item['sum'];
                $details = [
                    'o_id' => $order_id,
                    'pro_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'total_price' => $item['sum'],
                    'price' => $item['price']
                ];
                $detail = $this->orderDetailService->repository()->create($details);
            }
            //save order
            $inputs = [
                'o_id' => $order_id,
                'o_status' => 0,
                'cus_id' => $id,
                'total' => $total,
                'p_id' => $inputs['payment'],
                'o_add' => $address
            ];
            $order = $this->orderService->repository()->create($inputs);

            //delete session cart
            Session::forget('cart');
            DB::commit();
            return redirect()->route('user-home')->with([
                'message' => 'Đặt hàng thành công'
            ]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->route('user-home')->with([
                'errorMessage' => 'Đặt hàng thất bại !!!'
            ]);
        }

    }

    public function orderDetail ($pk){
        $query = DB::select('SELECT * 
                            FROM ((order_detail INNER JOIN product ON order_detail.pro_id = product.pro_id) 
                                INNER JOIN `order` ON `order`.o_id = order_detail.o_id)
                                    INNER JOIN customer ON `order`.cus_id = customer.cus_id
                            WHERE order_detail.o_id = '. $pk .'
                ');
        $data = json_decode(json_encode($query), true);
        return response()->json($data);
    }
}
