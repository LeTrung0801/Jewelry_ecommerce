<?php
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
	if(!empty(old())) {
		$inputs = old();
	}
    // $checkFlag = AppData::check_flag;
	// if($formType == 'edit') {
	// 	$buttonSubmit = 'Cập nhật';
	// } else {
	// 	$buttonSubmit = 'Thêm';
	// }
    $role = AppData::accRole;
?>

@extends('admin.pages.dashboard')
@section('content')
<!-- Default Basic Forms Start -->
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box mb-30 form">
        <div class="clearfix">
            <div>
                <h4 class="text-blue h4 text-center"> Thông tin tài khoản </h4>
            </div>
        </div>
        @include('admin.shared.error')
        <form action="{{route('admin-profile')}}" method="post">
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Chức vụ</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" placeholder="Chức vụ"
                    readonly
                    name="acc_role" value="{{$role[Auth::guard('admin')->user()->acc_role]}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="email" placeholder="Email"
                    readonly
                    name="acc_email" value="{{Auth::guard('admin')->user()->acc_email}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tên nhân viên</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" placeholder="Tên"
                    name="acc_name" value="{{Auth::guard('admin')->user()->acc_name}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Phone</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="tel" placeholder="Số điện thoại"
                    name="acc_phone" value="{{Auth::guard('admin')->user()->acc_phone}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Password mới</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="password" placeholder="New Password"
                    name="new_pwd">
                </div>
            </div>
            <hr>
            <h6 class="text-blue h4 text-center"> Xác nhận thay đổi </h6>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Password</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="password" placeholder="Password"
                    name="acc_pwd">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </div>
</div>
<!-- Default Basic Forms End -->
@endsection
