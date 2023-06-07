<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CollectionService;
use App\Models\Category;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use App\Http\Requests\CollectionRequest;
use App\Http\Components\Util;


class CollectionController extends Controller
{
    private $collService;
    public function __construct(CollectionService $collectionService)
    {
        $this->collService = $collectionService;
    }

    public function list(Request $request){
        $key = $request->input('keyword');
        $conditions = [
            'keyword' => $key,
		];
        $list = $this->collService->repository()->search($conditions,[]);

        return view('admin.collection.list',[
            'list' => $list
        ]);
    }

    public function create(){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            return view('admin.collection.create');
        }else{
            return redirect()->route('admin-category-list')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function edit($pk){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            if(!empty($pk)){
                $path = public_path().'/collect-img/'.$pk;
                $imgs = Util::getImg($path);
                $collection = $this->collService->repository()->findByPk($pk);
                return view('admin.collection.edit',[
                    'inputs' => $collection,
                    'imgs' => $imgs,
                ]);
            }
        }else{
            return redirect()->route('admin-category-list')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function store(CollectionRequest $request){
        try {
            $inputs = [
                'collect_name' => $request->input('collect_name')
            ];

            $img = $request->file('collect_img');

            $name_img = '1.'.$img->getClientOriginalExtension();

            $new_collect = $this->collService->repository()->create($inputs);

            $path = public_path().'/collect-img/'.$new_collect->collect_id;
            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
                $img->move($path,$name_img);
            }

            return redirect()->route('admin-collection-list')->with([
                'message' => 'Thêm dòng sản phẩm thành công '
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin-collection-list')->with([
                'errorMessage' => 'Thêm dòng sản phẩm không thành công !!!'
            ]);
        }
    }

    public function update(CollectionRequest $request ,$pk){
        $collect = $this->collService->repository()->findByPk($pk);
        if(!empty($collect)){
            $inputs = [
                'collect_name' => $request->input('collect_name'),
            ];

            $path = public_path().'/collect-img/'.$pk;

            if ($request->hasFile('collect_img')) {
                Util::unlinkFile($path, 1);
                $img = $request->file('collect_img');
                $name_img = '1.'.$img->getClientOriginalExtension();
                $img->move($path,$name_img);

            }
            $collect->update($inputs);
            return redirect()->route('admin-collection-list')->with([
                'message' => 'Cập nhật danh mục thành công '
            ]);

        } else {
            return redirect()->route('admin-collection-list')->with([
                'errorMessage' => 'Cập nhật danh mục không thành công '
            ]);
        }
    }

    public function delete($pk){
        if(Auth::guard('admin')->user()->acc_role == 0 || Auth::guard('admin')->user()->acc_role == 1){
            $coll = $this->collService->repository()->updateByPk($pk,['delete_flag'=>1]);
            session()->flash('message', 'done');
        }else{
            session()->flash('errorMessage', 'Bạn không có quyền thực hiện chức năng này!');
        }
        return response()->json();
    }
}
