<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CategoryService;
use App\Models\Category;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use App\Http\Requests\CategoryRequest;
use App\Http\Components\Util;



class CategoryController extends Controller
{
    private $catService;
    public function __construct(CategoryService $categoryService)
    {
        $this->catService = $categoryService;
    }

    public function list(Request $request){
        $key = $request->input('keyword');
        $conditions = [
            'keyword' => $key,
		];
        $list = $this->catService->repository()->search($conditions,[]);

        return view('admin.category.list',[
            'list' => $list
        ]);
    }

    public function create(){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            return view('admin.category.create');
        }else{
            return redirect()->route('admin-category-list')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function edit($pk){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            if(!empty($pk)){
                $path = public_path().'/category-img/'.$pk;
                $imgs = Util::getImg($path);
                $category = $this->catService->repository()->findByPk($pk);
                return view('admin.category.edit',[
                    'inputs' => $category,
                    'imgs' => $imgs,
                ]);
            }
        }else{
            return redirect()->route('admin-category-list')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function store(Request $request){
        try {
            $inputs = [
                'cat_name' => $request->input('cat_name')
            ];

            $img = $request->file('cat_img');

            $name_img = '1.'.$img->getClientOriginalExtension();

            $new_cat = $this->catService->repository()->create($inputs);

            $path = public_path().'/category-img/'.$new_cat->cat_id;
            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
                $img->move($path,$name_img);
            }

            return redirect()->route('admin-category-list')->with([
                'message' => 'Thêm danh mục thành công '
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin-category-list')->with([
                'errorMessage' => 'Thêm danh mục không thành công !!!'
            ]);
        }
    }

    public function update(CategoryRequest $request ,$pk){

        $cat = $this->catService->repository()->findByPk($pk);
        if(!empty($cat)){
            $inputs = [
                'cat_name' => $request->input('cat_name'),
            ];

            $path = public_path().'/category-img/'.$pk;

            if ($request->hasFile('cat_img')) {
                Util::unlinkFile($path, 1);
                $img = $request->file('cat_img');
                $name_img = '1.'.$img->getClientOriginalExtension();
                $img->move($path,$name_img);

            }
            $cat->update($inputs);
            return redirect()->route('admin-category-list')->with([
                'message' => 'Cập nhật danh mục thành công '
            ]);

        } else {
            return redirect()->route('admin-category-list')->with([
                'errorMessage' => 'Cập nhật danh mục không thành công '
            ]);
        }
    }

    public function delete($pk){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            $cat = $this->catService->repository()->updateByPk($pk,['delete_flag'=>1]);
            session()->flash('message', 'done');
        }else{
            session()->flash('errorMessage', 'Bạn không có quyền thực hiện chức năng này!');
        }
        return response()->json();

    }
}
