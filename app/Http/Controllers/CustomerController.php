<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Crypt;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Http\Services\CustomerService;
use App\Http\Services\OrderService;
use App\Http\Repositories\CustomerRepository;
use App\Http\Requests\CustomerRequest;
use App\Http\Components\Util;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Hash;


class CustomerController extends Controller
{
    private $service;
    private $orderService;

    public function __construct(CustomerService $customerService, OrderService $orderService)
    {
        $this->service = $customerService;
        $this->orderService = $orderService;
    }

    public function register(CustomerRequest $request){
        $inputs = [
            'cus_email' => $request->input('user_email'),
            'cus_pwd' => bcrypt($request->input('user_password')),
            'cus_phone' => $request->input('user_phone'),
            'cus_name' => $request->input('user_name'),
            'cus_status' => 0
        ];

        $cus = Customer::where('cus_email',$request->input('user_email'))->first();

        if(!empty($cus)){

            return redirect()->route('user-register')->with([
                'errorMessage' => 'Email này đã được đăng ký trước đó !'
            ]);
        } else {
            $token = (Str::random(64));
            $data = [
                'token' => $token,
                'url' => route('user-confirm',['token' => $token]),
                'title' => "LINK XÁC NHẬN ĐĂNG KÝ THÀNH VIÊN"
            ];
            $inputs['token'] = $token;

            DB::beginTransaction();
            try{
                $user = $this->service->repository()->create($inputs);

                $this->mail($user, $data);
                DB::commit();
            } catch(\Exception $e){
                DB::rollBack();
            }

            return redirect()->route('user-login')->with([
                'message' => 'Đăng ký thành công. HÃY KIỂM TRA EMAIL'
            ]);
        }
    }

	public function login(Request $request){
        // dd(bcrypt('123'));
        $inputs = [
            'cus_email' => $request->input('user_email'),
            'password' => $request->input('user_password')
        ];

        if($request->isMethod('post')){
            if(Auth::guard('cus')->attempt($inputs)){
                $status = Auth::guard('cus')->user()->cus_status;
                if($status == 1){
                    return redirect()->route('user-home');

                }elseif ($status == 2){
                    Auth::guard('cus')->logout();
                    return redirect()->back()->with([
                        'errorMessage' => 'Tài khoản của bạn đã bị khóa !!!'
                    ]);
                } else {
                    Auth::guard('cus')->logout();
                    return redirect()->back()->with([
                        'errorMessage' => 'Tài khoản của bạn chưa được kích hoạt !!!'
                    ]);
                }
            }else{
                return redirect()->back()->with([
                    'errorMessage' => 'Email hoặc mật khẩu bị sai !!!'
                ]);
            }
        }
        return view('user.pages.login')->with([
            'inputs' => $inputs
        ]);
    }

    public function confirm($token, Request $request){

        $cus= Customer::where('token',$token)->first();
        if(!empty($cus)){
            if($request->isMethod('post')){
                $inputs = [
                    'cus_email' => $request->input('user_email'),
                    'password' => $request->input('user_password'),
                    'token' => $token
                ];
                if(Auth::guard('cus')->attempt($inputs)){
                    $cus->update([
                        'cus_status'=> 1,
                        'token' => null
                    ]);
                    return redirect()->route('user-home');
                }else{
                    return redirect()->back()->with([
                        'errorMessage' => 'Thông tin tài khoản không đúng!'
                    ]);
                }
            } else {
                return view('user.pages.login')->with([
                    'token' => $token
                ]);
            }
        } else {
            abort(404);
        }
    }

    public function logout() {
        Auth::guard('cus')->logout();
		return redirect()->route('user-home');
	}

    public function forgetPass(Request $request){

        if($request->isMethod('post'))
        {
            $request->validate([
                'cus_email' => 'required|email'
            ],
            [
                'required' => 'Vui lòng nhập email !!!',
                'email' => 'Vui lòng nhập đúng định dạng email !!!'
            ]);
            $data = [
                'cus_email' => $request->cus_email
            ];

            $user = Customer::where('cus_email',$request->input('cus_email'))->first();

            if($user){

                $data['token'] = (Str::random(64));
                $user->update([
                    'token'=> $data['token']
                ]);

                $data['url'] = route('user-resetpass',['token' => $data['token']]);
                $data['title'] = "LINK ĐẶT LẠI MẬT KHẨU";
                $this->mail($user, $data);

                return redirect()->route('user-login')->with([
                    'message' => 'Vui lòng kiểm tra email!'
                ]);
            } else {
                return redirect()->route('user-login')->with([
                    'errorMessage' => 'Email này chưa được đăng ký'
                ]);
            }

        }

        return view('user.pages.reset-pass');
    }

    public function resetPass ($token, Request $request){
        $user= Customer::where('token',$token)->first();
        if(!empty($user)){
            return view('user.pages.reset-pass',[
                'token' => $token
            ]);
        } else {
            abort(404);
        }
    }

    public function postResetPass(Request $request){
        $request->validate([
            'cus_email' => 'required|email',
            'cus_pwd' => 'required',
            'cus_pwd_confirm' => 'required|same:cus_pwd',
        ],
        [
            'cus_email.required' => 'Vui lòng nhập email !!!',
            'cus_email.email' => 'Vui lòng nhập đúng định dạng email !!!',
            'cus_pwd.required' => 'Vui lòng nhập mật khẩu !!!',
            'cus_pwd_confirm.*' => 'Mật khẩu không khớp !!!',
        ]);

        $data = [
            'cus_email' => $request->input('cus_email'),
            'token' => $request->input('token'),
            'password' => $request->input('cus_pwd')
        ];

        $user= Customer::where('token',$data['token'])->where('cus_email',$data['cus_email'])->first();
        if(!empty($user)){
            DB::beginTransaction();
            try{
                $user->update([
                    'cus_pwd' => Hash::make($data['password']),
                    'cus_status' => 1,
                    'token'=> null
                ]);
                DB::commit();
            } catch(\Exception $e){
                DB::rollBack();
            }
            return redirect()->route('user-login')->with([
                'message' => 'Thông tin đã được cập nhật!'
            ]);
        } else {
            return redirect()->back()->with([
                'errorMessage' => 'Thông tin tài khoản không đúng!'
            ]);
        }
    }

    public function mail($user, $data){
        Mail::send('admin.mail.resetpassword', $data, function($message) use($user, $data) {
            $message->to($user->cus_email, '')->subject
                ($data['title']);
            $message->from('testmailsmartnet@gmail.com','BORCELLE');
        });
    }

    public function list(Request $request){
        if(Auth::guard('admin')->user()->acc_role == 0){
            $key = $request->input('keyword');
            $conditions = [
                'keyword' => $key,
            ];
            $options = [
                'get' => true,
            ];
            $list = $this->service->repository()->search($conditions, $options);

            return view('admin.customer.list',[
                'list' => $list
            ]);
        }
        else{
            return redirect()->route('admin-home')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function changeStatus(Request $request){
        $cus_id = $request->id;
        $user = $this->service->repository()->findByPk($cus_id);
        if($user->cus_status == 2){
            $user->update(['cus_status' => 1]);
            $result = 1;
        }else{
            $user->update(['cus_status' => 2]);
            $result = 0;
        }
        return response()->json($result);
    }

    public function delete($pk){
        $user = $this->service->repository()->updateByPk($pk,['delete_flag'=>1]);
        session()->flash('message', 'done');
        return response()->json();
    }

    public function index(){
        $id = Auth::guard('cus')->user()->cus_id;
        $info = Customer::find($id);
        $city=Util::getCity();
        return view('user.user-info.my-account')->with([
            'info' => $info,
            'cities' => $city,
            'action' => 'profile'
        ]);
    }

    public function editUserProfile(CustomerRequest $request){
        $inputs = [
            'cus_name' => $request->input('user_name'),
            'cus_phone' => $request->input('user_phone'),
            'cus_email' => $request->input('user_email'),
            'city_id' => $request->input('city'),
            'dis_id' => $request->input('district'),
            'ward_id' => $request->input('ward'),
            'cus_add' => $request->input('cus_add'),
            'cus_pwd' => $request->input('user_password'),
            'new_pwd' => $request->input('new_pwd'),
        ];

        $user = Customer::find(Auth::guard('cus')->user()->cus_id);

        if(Hash::check($inputs['cus_pwd'], $user->cus_pwd)){

            if(empty($inputs['new_pwd'])){
                unset($inputs['new_pwd']);
                unset($inputs['cus_pwd']);
            }else{
                $inputs['cus_pwd'] = bcrypt($inputs['new_pwd']);
                unset($inputs['new_pwd']);
            }

            $user->update($inputs);
            return redirect()->back()->with([
                'message' => 'Cập nhật thông tin thành công'
            ]);
        }else{
            return redirect()->back()->with([
                'errorMessage' => 'Sai password',
            ]);
        }
    }

    public function indexHistory (){
        $id = Auth::guard('cus')->user()->cus_id;
        $list = Order::where('o_status', '<>', 3)
                        ->where('cus_id', $id)->get();

        $info = Customer::find($id);
        $city=Util::getCity();
        return view('user.user-info.order')->with([
            'list' => $list,
            'info' => $info,
            'action' => 'order-history'
        ]);
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

    public function changeStatusOrder(Request $request){
        $o_id = $request->id;
        $order = $this->orderService->repository()->findByPk($o_id);
        if($order->o_status == 0){
            $order->update(['o_status' => 3]);
            $result = 1;
        }elseif ($order->o_status == 1){
            $order->update(['o_status' => 2]);
        }else {

        }
        return response()->json();

    }
}
