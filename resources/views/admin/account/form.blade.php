<?php
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
	if(!empty(old())) {
		$inputs = old();
	}
    // $checkFlag = AppData::check_flag;
	if($formType == 'edit') {
		$buttonSubmit = 'Cập nhật';
	} else {
		$buttonSubmit = 'Thêm';
	}
    $role = AppData::accRole;
?>

@extends('admin.pages.dashboard')
@section('content')
<!-- Default Basic Forms Start -->
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box mb-30 form">
        <div class="clearfix">
            <div>
                <h4 class="text-blue h4 text-center"> @yield('title') </h4>
            </div>
        </div>
        @include('admin.shared.error')
        <form action="{{$route}}" method="post">
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Chức vụ</label>
                <div class="col-sm-12 col-md-10">
                    <select class=" form-control" data-style="btn-outline-primary" name="acc_role">
                        <option selected disabled>Vui lòng chọn --</option>
                        @foreach($role as $value => $name)
                        <option value="{{$value}}"
                        {{isset($inputs['acc_role']) && $value == $inputs['acc_role'] ? 'selected' : ''}}>
                        {{$name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tên nhân viên</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" placeholder="Tên"
                    name="acc_name" value="{{$inputs['acc_name'] ?? ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="email" placeholder="Email"
                    name="acc_email" value="{{$inputs['acc_email'] ?? ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Phone</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="tel" placeholder="Số điện thoại"
                    name="acc_phone" value="{{$inputs['acc_phone'] ?? ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Password</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="password" placeholder="Password"
                    name="acc_pwd">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{$buttonSubmit}}</button>
        </form>
    </div>
</div>
<!-- Default Basic Forms End -->
@endsection
