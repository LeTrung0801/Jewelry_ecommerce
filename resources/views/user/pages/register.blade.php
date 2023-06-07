<?php
    if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
@section('css')
<link rel="stylesheet" href="{{ asset('html/admin/css/style.css') }}">
@endsection

@extends('user.layouts.app')
@section('title, Register')
@section('content')
<div class="d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{ asset('html/user/images/logo/favicon.png') }}" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-pink">Đăng Ký</h2>
                    </div>
                    @include('user.shared.error', ['validateErorrs' => $errors->messages()])
                    <form action="{{route('user-register')}}" method="post">
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" placeholder="Họ Tên" name="user_name">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" placeholder="SĐT" name="user_phone">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy fa fa-phone"></i></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="email" class="form-control form-control-lg" placeholder="Email" name="user_email">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy fa fa-envelope" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" placeholder="Password" name="user_password">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" placeholder="Xác Nhận Password" name="user_password_confirm">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button type="submit" class="btn btn-pink btn-lg btn-block">ĐĂNG KÝ</button>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@stop
