<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Services\CategoryService;
use App\Http\Services\CollectionService;

use App\Models\District;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    private $catService;
    private $colService;
    private $proService;

    public function __construct(CategoryService $catService, CollectionService $colService, ProductService $proService){
        $this->catService = $catService;
        $this->colService = $colService;
        $this->proService = $proService;
    }

    //
    public function index(){
        $cat = $this->catService->getList();
        $col = $this->colService->getList();
        $proNew = $this->proService->getListNew();
        $proCollect = $this->proService->getListCollect(2);
        return view('user.pages.home',[
            'cat' => $cat,
            'col' => $col,
            'pronew' => $proNew,
            'procol' => $proCollect
        ]);
    }
    public function login(){
        return view('user.pages.login');
    }
    public function register(){
        return view('user.pages.register');
    }

    public function about()
    {
        return view('user.pages.about');
    }

    public function getDistrict(Request $request){
        $city=$request->city;
        $district = DB::table('district')->where('matp',$city)->orderBy('maqh','asc')->get();
        return response()->json($district);
    }
    public function getWard(Request $request){
        $district=$request->district;
        $ward=DB::table('ward')->where('maqh',$district)->orderBy('xaid','asc')->get();
        return response()->json($ward);
    }

    public function user_information()
    {
        return view('user.user-info.user-information');

    }
}
