<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Components\Util;

use App\Models\Product;
use App\Http\Services\ProductService;
use App\Http\Services\CategoryService;
use App\Http\Services\CollectionService;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use App\Http\Helpers\AppData;

use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    private $catService;
    private $colService;
    private $service;
    private $repository;
    private $proService;

    public function __construct(ProductService $service, CategoryService $catService, CollectionService $colService, ProductService $proService)
    {
        $this->service = $service;
        $this->repository = $service->repository();
        $this->catService = $catService;
        $this->colService = $colService;
        $this->proService = $proService;
    }

    public function listUser(Request $request){
        $key = $request->input('keyword');
        $category = $request->cat;
        $collect = $request->col;
        $material = $request->material;
        $conditions=[
            'quantity' => 0,
            'keyword' => $key,
            'category' => $category,
            'collect' => $collect,
            'material' => $material
        ];
        $options=[
            // 'get' => true
        ];
        $cat = $this->catService->getList();
        $col = $this->colService->getList();
        $pro = $this->repository->search($conditions, $options);

        return view('user.pages.product',[
            'cat' => $cat,
            'col' => $col,
            'pro' => $pro,
        ]);
    }

    public function detail($id){
        $pro = Product::find($id);
        if(!empty($pro)){
            $cat = $this->catService->getList();
            $col = $this->colService->getList();
            $re_pro = $this->proService->getListCategory($pro->pro_cat_id);
            // dd($re_pro);
            return view('user.pages.product_detail')->with([
                'pro' => $pro,
                'cat' => $cat,
                'col' => $col,
                're_pro' => $re_pro
            ]);
        }else{
            abort(404);
        }
    }

    public function list (Request $request){
        $key = $request->input('keyword');
        $conditions = [
            'keyword' => $key,
		];
        $options = [
            'orderbydesc' => 'pro_id'
        ];
        $cat = $this->catService->getList();
        $col = $this->colService->getList();
        $list = $this->service->repository()->search($conditions, $options);
        return view('admin.product.list',[
            'list' => $list,
            'category' => $cat,
            'collection' => $col,
        ]);
    }

    public function listShort(Request $request, Product $product){
        $inputs = $request->all();

        $cattegory = array();
        $colection = array();
        $material = array();
        foreach($inputs as $key => $value){
            if(current(explode('-',$key))=='cate'){
                array_push($cattegory,str_replace('cate-', ' ', $key));
            }
            if(current(explode('-',$key))=='collect'){
                array_push($colection,str_replace('collect-', ' ', $key));
            }
            if(current(explode('-',$key))=='material'){
                array_push($material,str_replace('material-', ' ', $key));
            }
        }

        $query = $product;
        if(!empty($cattegory)){
            $query = $query->whereIn('pro_cat_id',$cattegory);
        }
        if(!empty($colection)){
            $query = $query->whereIn('pro_collect_id',$colection);
        }
        if(!empty($material)){
            $query = $query->whereIn('m_id',$material);
        }
        $list = $query->where('delete_flag',0)->paginate(AppData::defaultPaginate);
        //------lấy tất cả--------
        // $list = Product::whereIn('pro_cat_id',$cattegory)
        // ->orWhere(function($query )use($colection, $material){
        //     $query->whereIn('pro_collect_id',$colection)
        //         ->orWhere(function($q)use($material){
        //             $q->whereIn('m_id',$material);
        //         });
        // })->get();

        $cat = $this->catService->getList();
        $col = $this->colService->getList();

        return view('admin.product.list',[
            'list' => $list,
            'category' => $cat,
            'collection' => $col,
        ]);
    }

    public function create(Request $request){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            $pro = [
                'pro_name' => $request->input('pro_name',null),
                'pro_price' => $request->input('pro_price',null),
                'pro_price_sale' => $request->input('pro_price_sale',null),
                'pro_qty' => $request->input('pro_qty',null),
                'm_id' => $request->input('m_id',null),
                'pro_cat_id' => $request->input('pro_cat_id',null),
                'pro_collect_id' => $request->input('pro_collect_id',null),
                'pro_description' => $request->input('pro_description',null),
            ];

            $cat = Util::getCat();
            $col = Util::getCol();
            return view('admin.product.create',[
                'inputs' =>$pro,
                'cat' => $cat,
                'col' => $col
            ]);
        }else{
            return redirect()->route('admin-product-list')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function store(ProductRequest $request) {
        try {
            $inputs = [
                'pro_name' => $request->input('pro_name'),
                'pro_price' => $request->input('pro_price'),
                'pro_price_sale' =>$request->input('pro_price_sale'),
                'pro_qty' => $request->input('pro_qty'),
                'pro_description' => $request->input('pro_description'),
                'm_id' => $request->input('m_id'),
                'pro_cat_id' => $request->input('pro_cat_id'),
                'pro_collect_id' => $request->input('pro_collect_id',null)
            ];

            $img1 = $request->file('img_1');
            $img2 = $request->file('img_2');

            $name_img1 = '1.'.$img1->getClientOriginalExtension();
            $name_img2 = '2.'.$img2->getClientOriginalExtension();

            $new_pro = $this->repository->create($inputs);

            $path = public_path().'/product-img/'.$new_pro->pro_id;
            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
                $img1->move($path,$name_img1);
                $img2->move($path,$name_img2);
            }

            return redirect()->route('admin-product-list')->with([
                'message' => 'Thêm sản phẩm thành công '
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin-product-list')->with([
                'errorMessage' => 'Thêm sản phẩm không thành công !!!'
            ]);
        }
    }

    public function edit($pk){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            $cat = Util::getCat();
            $col = Util::getCol();
            if(!empty($pk)){
                $pro = Product::find($pk);
                $path = public_path().'/product-img/'.$pk;
                $imgs = $this->getImg($path);
                // dd($imgs);
                return view('admin.product.edit',[
                    'inputs' => $pro,
                    'imgs' => $imgs,
                    'cat' => $cat,
                    'col' => $col
                ]);
            }
        }else{
            return redirect()->route('admin-product-list')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function getImg($path){
        $imgs = [];
        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    array_push($imgs, $entry);
                }
            }
            closedir($handle);
        }
        return $imgs;
    }

    public function unlinkFile($path, $namefile){
        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (current(explode('.',$entry)) == $namefile ) {
                        unlink($path.'/'.$entry);
                    }
                }
            }
            closedir($handle);
        }
    }

    public function update(ProductRequest $request, $pk){
        $pro = $this->repository->findByPk($pk);
        if(!empty($pro)){
            $inputs = [
                'pro_name' => $request->input('pro_name'),
                'pro_price' => $request->input('pro_price'),
                'pro_price_sale' =>$request->input('pro_price_sale'),
                'pro_qty' => $request->input('pro_qty'),
                'pro_description' => $request->input('pro_description'),
                'm_id' => $request->input('m_id'),
                'pro_cat_id' => $request->input('pro_cat_id'),
                'pro_collect_id' => $request->input('pro_collect_id',null)
            ];

            $path = public_path().'/product-img/'.$pk;

            if ($request->hasFile('img_1')) {
                $this->unlinkFile($path, 1);
                $img1 = $request->file('img_1');
                $name_img1 = '1.'.$img1->getClientOriginalExtension();
                $img1->move($path,$name_img1);

            }
            if ($request->hasFile('img_2')) {
                $this->unlinkFile($path, 2);
                $img2 = $request->file('img_2');
                $name_img2 = '2.'.$img2->getClientOriginalExtension();
                $img2->move($path,$name_img2);
            }

            $pro->update($inputs);
            return redirect()->route('admin-product-list')->with([
                'message' => 'Cập nhật sản phẩm thành công '
            ]);

        } else {
            return redirect()->route('admin-product-list')->with([
                'errorMessage' => 'Cập nhật sản phẩm không thành công '
            ]);
        }

    }

    public function delete($pk){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            $pro = $this->service->repository()->updateByPk($pk,['delete_flag'=>1]);
            session()->flash('message', 'done');
        }else{
            session()->flash('errorMessage', 'Bạn không có quyền thực hiện chức năng này!');
        }
        return response()->json();
    }

}
