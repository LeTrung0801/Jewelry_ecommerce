<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

use App\Http\Components\Util;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;

class CartController extends Controller
{
    public function list(){
        return view('user.pages.cart');
    }

    public function addCart(Request $request, $pro_id){
        $quantity = 0;
        if(!empty($request->input('qty'))){
            $quantity = $request->input('qty');
        }else{
            $quantity = 1;
        }

        $product = Product::find($pro_id);
        $cart = Session::get('cart');
        if(isset($cart[$pro_id])){
            $cart[$pro_id]['qty']+=$quantity;
            $cart[$pro_id]['sum']=$cart[$pro_id]['qty']*$cart[$pro_id]['price'];
        }else{
            $cart[$pro_id] = [
                'id' => $pro_id,
                'name' => $product->pro_name,
                'price' => $product->pro_price,
                'qty' => $quantity,
                'sum' => $quantity*$product->pro_price,
            ];
        }
        Session::put('cart', $cart);
        return redirect()->back()->with([
            'message' => 'Sản phẩm đã thêm vào giỏ hàng'
        ]);
    }

    public function changeCart($pk,Request $request){
        $cart = Session::get('cart');
        if(isset($cart[$pk])){
            if($request->act == 1){
                if($request->quantity < 100){
                    $cart[$pk]['qty']+=1;
                }else{
                    $cart[$pk]['qty']=100;
                }
            }else{
                if($request->quantity > 1){
                    $cart[$pk]['qty']-=1;
                } else{
                    $cart[$pk]['qty']=1;
                }
            }
            $cart[$pk]['sum']=$cart[$pk]['qty']*$cart[$pk]['price'];
            Session::put('cart', $cart);
            $total = 0;
            foreach($cart as $item){
                $total = $total + $item['sum'];
            }
            $result = $cart[$pk];
            return response()->json([
                'item' => $result,
                'total' => $total
            ]);
        }else{
            $result = 0;
            return response()->json($result);
        }
    }

    public function deleteItemCart($pk){
        $cart=Session::get('cart');
        if(isset($cart[$pk])){
            unset($cart[$pk]);
        }
        Session::put('cart', $cart);
        if(empty($cart)){
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function deleteCart(){
        Session::forget('cart');
        return redirect()->back();
    }

    public function checkout(Request $request){
        if(Auth::guard('cus')->check()){
            $cart=Session::get('cart');
            $total = 0;
            foreach($cart as $item){
                $total = $total + $item['sum'];
            }
            $customer = Auth::guard('cus')->user();

            $cusCity = $customer->city_id ? $customer->city_id : '';
            $cusDistrict = $customer->dis_id ? $customer->dis_id : '';
            $cusWard = $customer->ward_id ? $customer->ward_id : '';
            if (!empty($cusCity)) {
                if ($cusCity < 10){
                    $cusCity = str_pad($cusCity, 2, '0', STR_PAD_LEFT);
                }
                if ($cusDistrict < 100){
                    $cusDistrict = str_pad($cusDistrict, 3, '0', STR_PAD_LEFT);
                }
                if ($cusWard < 10000){
                    $cusWard = str_pad($cusWard, 5, '0', STR_PAD_LEFT);
                }
            }
            $city = City::find($cusCity);
            $district = District::find($cusDistrict);
            $ward = Ward::find($cusWard);
            if (!empty($city) && !empty($district) && !empty($ward)){
                $cusAdd = $customer->cus_add.', '.$ward->name.', '.$district->name.', '.$city->name;
            } else {
                $cusAdd = '';
            }
            
            $cities = Util::getCity();
            $payment = Util::getPayment();
            return view('user.pages.checkout')->with([
                'cities' => $cities,
                'cusAdd' => $cusAdd,
                'total' => $total,
                'payment' => $payment,
                'customer' => $customer
            ]);
        }else{
            return redirect()->back()->with([
                'errorMessage' => 'Vui lòng đăng nhập để đặt hàng !!!'
            ]);
        }

    }
}
