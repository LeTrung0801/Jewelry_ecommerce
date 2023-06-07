<?php
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
	if(!empty(old())) {
		$inputs = old();
	}
	if($formType == 'edit') {
		$buttonSubmit = 'Cập nhật';
        $edit = true;
	} else {
		$buttonSubmit = 'Thêm';
        $edit = false;
	}
?>

@extends('admin.pages.dashboard')
@section('content')
<!-- Default Basic Forms Start -->
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box mb-30 form">
        <div class="clearfix">
            <div>
                <h4 class="text-blue h4 text-center">@yield('title')</h4>
            </div>
        </div>
        @include('admin.shared.error')
        <form action="{{$route}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="edit" value="{{ $edit }}">
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tên danh mục</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" placeholder="Tên"
                    name="cat_name" value="{{ $inputs['cat_name'] ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Thumbnail</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="file" name="cat_img" value="">
                    @if (!empty($inputs['cat_id']))
                    <img class="w-25 pt-2" src="{{ asset('category-img/'.$inputs['cat_id'].'/'.$imgs[0]) }}">
                    @endif
                </div>
            </div>
            <button class="btn btn-primary">{{ $buttonSubmit }}</button>
        </form>
    </div>
</div>
<!-- Default Basic Forms End -->
@endsection
