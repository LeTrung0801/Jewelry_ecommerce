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
    $materials = AppData::material;
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
        <form action="{{$route}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tên Sản Phẩm</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" name="pro_name" value="{{$inputs['pro_name'] ?? ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Giá Gốc</label>
                <div class="col-sm-12 col-md-4">
                    <input class="form-control" type="text" name="pro_price" value="{{!empty($inputs['pro_price']) ? $inputs['pro_price'] : ''}}">
                </div>
                <label class="col-sm-12 col-md-2 col-form-label">Giá Sale</label>
                <div class="col-sm-12 col-md-4">
                    <input class="form-control" type="text" name="pro_price_sale" value="{{!empty($inputs['pro_price_sale']) ? $inputs['pro_price_sale'] : ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Hình 1</label>
                <div class="col-sm-12 col-md-4 text-center">
                    <input class="form-control" type="file" name="img_1">
                    @if (!empty($inputs['pro_id']))
                    <img class="w-50 pt-2" src="{{ asset('product-img/'.$inputs['pro_id'].'/'.$imgs[0]) }}">
                    @endif
                </div>
                <label class="col-sm-12 col-md-2 col-form-label">Hình 2</label>
                <div class="col-sm-12 col-md-4 text-center">
                    <input class="form-control" type="file" name="img_2" value="">
                    @if (!empty($inputs['pro_id']))
                    <img class="w-50 pt-2" src="{{ asset('product-img/'.$inputs['pro_id'].'/'.$imgs[1]) }}">
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Số Lượng</label>
                <div class="col-sm-12 col-md-4">
                    <input class="form-control" type="number" name="pro_qty" value="{{$inputs['pro_qty'] ?? ''}}" min="0">
                </div>
                <label class="col-sm-12 col-md-2 col-form-label">Chất Liệu</label>
                <div class="col-sm-12 col-md-4">
                    <select class=" form-control" data-style="btn-outline-primary" name="m_id">
                        <option selected disabled>Vui lòng chọn --</option>
                        @foreach($materials as $key => $material)
                        <option value="{{$key}}"
                        {{isset($inputs['m_id']) && $key == $inputs['m_id'] ? 'selected' : ''}}>
                        {{$material}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Loại Sản Phẩm</label>
                <div class="col-sm-12 col-md-4">
                    <select class=" form-control" data-style="btn-outline-primary" name="pro_cat_id">
                        <option selected disabled>Vui lòng chọn --</option>
                        @foreach($cat as $key => $value)
                        <option value="{{$key}}"
                        {{isset($inputs['pro_cat_id']) && $key == $inputs['pro_cat_id'] ? 'selected' : ''}}>
                        {{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-12 col-md-2 col-form-label">Dòng Sản Phẩm</label>
                <div class="col-sm-12 col-md-4">
                    <select class=" form-control" data-style="btn-outline-primary" name="pro_collect_id">
                        <option selected disabled>Vui lòng chọn --</option>
                        @foreach($col as $key => $value)
                        <option value="{{$key}}"
                        {{isset($inputs['pro_collect_id']) && $key == $inputs['pro_collect_id'] ? 'selected' : ''}}>
                        {{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Mô Tả</label>
                <div class="col-sm-12 col-md-10">
                    <textarea rows="3" class="form-control" type="textarea"  name="pro_description" value="{{$inputs['pro_description'] ?? ''}}">{{$inputs['pro_description']}}</textarea>
                </div>
            </div>
            <input type="hidden" name="edit" id="token" value="{{ $edit }}">
            <button type="submit" class="btn btn-primary">{{$buttonSubmit}}</button>
        </form>
    </div>
</div>
<!-- Default Basic Forms End -->
@endsection
