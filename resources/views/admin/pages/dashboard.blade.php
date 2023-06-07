@extends('admin.layouts.app')
@section('dashboard')
    @include('admin.shared.topbar')
    <div class="main-container">
    @include('admin.shared.sidebar')
    {{-- @include('admin.shared.breadcrumb', [
							'breadcrumbs' => !empty($breadcrumbs)?$breadcrumbs:[]
						]) --}}
    @yield('content')
    <input type="hidden" name="message"
    value="{{session()->has('message')?session('message'):''}}"/>
    <?php
        if(Session::has('errorMessage')) {
            $errorMessage = Session::get('errorMessage');
        }
    ?>
    <input type="hidden" name="error-message"
    value="{{!empty($errorMessage)?$errorMessage:''}}"/>
    {{-- @include('admin.layouts.form') --}}
    </div>
@endsection
