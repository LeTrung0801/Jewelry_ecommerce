<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppData;
use App\Http\Components\Util;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests\AccountRequest;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Order;

use App\Http\Services\AccountService;

use DB;



class AccountController extends Controller
{
    private $service;

    public function __construct(AccountService $accountService)
    {
        $this->service = $accountService;
    }

	public function login(Request $request){
        // dd(bcrypt('123'));
        $success = true;
        $inputs = [
            'acc_email' => $request->input('acc_email', null),
            'password' => $request->input('acc_pwd', null),
            // 'acc_role' => 0,
            'acc_status' => 1
        ];
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin-home');
        }
        if($request->isMethod('post')){
            // $this->validate($request, self::rules, self::messages);
            if(Auth::guard('admin')->attempt($inputs)){
                return redirect()->route('admin-home');
            }else{
                $success = false;
            }
        }
        return view('admin.pages.login')->with([
            'success' => $success,
            'inputs' => $inputs
        ]);
    }

    public function index(Request $request){
        // dd($request->all());
        $month = $request->input('month');
        $year = $request->input('year');
        $cus = Customer::whereYear('created_at', 'like', '%'.$year)
                        ->whereMonth('created_at', 'like', '%'.$month)
                        ->count();
        $order = Order::where('o_status','<>', 3)
                        ->whereYear('created_at', 'like', '%'.$year)
                        ->whereMonth('created_at', 'like', '%'.$month)
                        ->count();
        $total_price = Order::where('o_status',2)
                        ->whereYear('created_at', 'like', '%'.$year)
                        ->whereMonth('created_at', 'like', '%'.$month)
                        ->sum('total');
        return view('admin.pages.home', [
            'cus' => $cus,
            'order' => $order,
            'total_price' => $total_price
        ]);
    }

	public function logout() {
        Auth::guard('admin')->logout();
		return redirect()->route('admin-login');
	}

    public function sendMail(Request $request) {

        if($request->isMethod('post'))
        {
            $request->validate([
                'acc_email' => 'required|email'
            ],
            [
                'required' => 'Vui lòng nhập email !!!',
                'email' => 'Vui lòng nhập đúng định dạng email !!!'
            ]);
            $data = [
                'acc_email' => $request->acc_email
            ];

            $accAd = Account::where('acc_email',$request->input('acc_email'))->first();

            if($accAd){

                $data['token'] = (Str::random(64));
                DB::beginTransaction();
                try{
                    $accAd->update([
                        'acc_token'=> $data['token']
                    ]);

                    $data['url'] = route('admin-resetpassmail',['token' => $data['token']]);

                    Mail::send('admin.mail.resetpassword', $data, function($message) use($accAd) {
                        $message->to($accAd->acc_email, '')->subject
                            ('LINK ĐẶT LẠI MẬT KHẨU');
                        $message->from('testmailsmartnet@gmail.com','BORCELLE');
                    });
                    DB::commit();
                } catch(\Exception $e){
                    DB::rollBack();
                }
            }
            $request->session()->flash('success','Vui lòng kiểm tra email!');
            return view('admin.pages.login');
        }

        return view('admin.pages.reset-pass');
    }

    public function resetPass ($token, Request $request){
        $accAd= Account::where('acc_token',$token)->first();
        if(!empty($accAd)){
            return view('admin.pages.reset-pass',[
                'token' => $token
            ]);
        } else {
            abort(404);
        }
    }

    public function postResetPass(Request $request){
        $request->validate([
            'acc_email' => 'required|email',
            'acc_pwd' => 'required',
            'acc_pwd_conf' => 'required|same:acc_pwd',
        ],
        [
            'acc_email.required' => 'Vui lòng nhập email !!!',
            'acc_email.email' => 'Vui lòng nhập đúng định dạng email !!!',
            'acc_pwd.required' => 'Vui lòng nhập mật khẩu !!!',
            'acc_pwd_conf.*' => 'Mật khẩu không khớp !!!',
        ]);
        $data = [
            'token' => $request->input('token'),
            'password' => $request->input('acc_pwd')
        ];

        $accAd= Account::where('acc_token',$data['token'])->first();
        if(!empty($accAd)){
            DB::beginTransaction();
            try{
                $accAd->update([
                    'acc_pwd' => Hash::make($data['password']),
                    'acc_token'=> null
                ]);
                DB::commit();
            } catch(\Exception $e){
                DB::rollBack();
            }
            return redirect()->route('admin-login')->with([
                'success' => 'Thông tin đã được cập nhật!'
            ]);
        } else {
            abort(404);
        }
    }

    // tạm thời search luôn ở đây
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

            return view('admin.account.list',[
                'list' => $list
            ]);
        }else{
            return redirect()->route('admin-home')->with([
               'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
            ]);
        }
    }

    public function create(Request $request){
        if(Auth::guard('admin')->user()->acc_role == 0){
            return view('admin.account.create');
        }else{
            return redirect()->route('admin-home')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
             ]);
        }
    }
    public function save(AccountRequest $request){
        $inputs = $request->all();


        $inputs['acc_pwd'] = bcrypt($inputs['acc_pwd']);

        $getaccount = Account::where('acc_email',$inputs['acc_email'])->first();
        if(empty($getaccount)){
            $staff = $this->service->repository()->create($inputs);

            return redirect()->route('admin-account-list')->with([
                'message' => 'success'
            ]);
        }else{
            return redirect()->back()->with([
                'errorMessage' => 'User already exist'
            ]);
        }
    }

    public function edit($pk){
        if(Auth::guard('admin')->user()->acc_role == 0){
            if(!empty($pk)){
                $staff = $this->service->repository()->findByPk($pk);
                return view('admin.account.edit',[
                    'inputs' => $staff,
                ]);
            }
        }else{
            return redirect()->route('admin-home')->with([
                'errorMessage' => 'Bạn không có quyền truy cập chức năng này!'
             ]);
        }
    }
    public function update(Request $request, $pk){
        $inputs = $request->all();

        if(empty($inputs['acc_pwd'])){
            unset($inputs['acc_pwd']);
        }else{
            $inputs['acc_pwd'] = bcrypt($inputs['acc_pwd']);
        }

        $getstaff = Account::where('acc_email',$request->input('acc_email'))
        ->where('acc_id','<>',$pk)->first();

        if(empty($getstaff)){
            $staff = $this->service->repository()->updateByPk($pk,$inputs);

            return redirect()->route('admin-account-list')->with([
                'message' => 'success',
            ]);
        }else{
            return redirect()->back()->with([
                'errorMessage' => 'Email already exist'
            ]);
        }
    }

    public function changeStatus(Request $request){
        $acc_id = $request->id;
        $staff = $this->service->repository()->findByPk($acc_id);
        if($staff->acc_status == 0){
            $staff->update(['acc_status' => 1]);
            $result = 1;
        }else{
            $staff->update(['acc_status' => 0]);
            $result = 0;
        }
        return response()->json($result);
    }

    public function delete($pk){
        $staff = $this->service->repository()->updateByPk($pk,['delete_flag'=>1]);
        session()->flash('message', 'done');
        return response()->json();
    }

    public function profile(Request $request){
        if($request->isMethod('post')){

            $inputs = $request->all();
            $pk = Auth::guard('admin')->user()->acc_id;
            $new = Account::find($pk);
            // dd(bcrypt('12345'));
            if(Hash::check($inputs['acc_pwd'], $new->acc_pwd)){

                unset($inputs['acc_role']);
                if(empty($inputs['new_pwd'])){
                    unset($inputs['new_pwd']);
                    unset($inputs['acc_pwd']);
                }else{
                    $inputs['acc_pwd'] = bcrypt($inputs['new_pwd']);
                    unset($inputs['new_pwd']);
                }
                $new->update($inputs);
                return redirect()->back()->with([
                    'message' => 'success'
                ]);
            }else{
                return redirect()->back()->with([
                    'errorMessage' => 'Sai password'
                ]);
            }
        }else{
            return view('admin.account.profile');
        }
    }



    public function export(){
        $query = Account::orderBy('acc_id','asc')->get();
        if($query!=null){
            $delimiter = ",";
            $filename = "staff-data_" . date('Y-m-d H:m:s') . ".csv";
            // Create a file pointer
            $f = fopen('php://memory', 'w');
            // Set column headers
            $fields = array('ID', 'NAME', 'EMAIL', 'PHONE', 'ROLE', 'STATUS', 'CREATE_AT', 'UPDATE_AT');
            fputcsv($f, $fields, $delimiter);
            // Output each row of the data, format line as csv and write to file pointer
            $accrole = AppData::accRole;
            foreach($query as $row){
                $role = $accrole[$row->acc_role];
                $status = ($row->acc_status == 1)?'Active':'Inactive';
                $lineData = array($row->acc_id, $row->acc_name, $row->acc_email, $row->acc_phone, $role, $status, $row->created_at, $row->updated_at);
                fputcsv($f, $lineData, $delimiter);
            }
            // Move back to beginning of file
            fseek($f, 0);
            // Set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            //output all remaining data on a file pointer
            fpassthru($f);
        }
        exit;
    }
}
