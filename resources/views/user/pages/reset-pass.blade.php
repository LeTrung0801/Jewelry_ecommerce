@extends('user.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('html/admin/css/style.css') }}">
@endsection

@section('title, Login')
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
                        <h2 class="text-center text-pink">Đặt Lại Mật Khẩu</h2>
                    </div>
                    <form action="{{isset($token) ? route('user-resetpass',['token'=>$token]) : route('user-forgetpass')}}" method="post">
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" placeholder="Email" name="cus_email">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                            </div>
                        </div>

                        @if (isset($token))
                        <input name="token" type="hidden" value="{{$token}}" />
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" placeholder="Mật khẩu" name="cus_pwd">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" placeholder="Nhập lại mật khẩu" name="cus_pwd_confirm">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            </div>
                        </div>
                        @include('user.shared.error')
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button class="btn btn-pink btn-lg btn-block">LƯU</button>
                                </div>
                            </div>
                        </div>
                        @else
                        @include('user.shared.error')
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button type="submit" class="btn btn-pink btn-lg btn-block">GỬI MAIL</button>
                                </div>
                            </div>
                        </div>
                        @endif
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@stop