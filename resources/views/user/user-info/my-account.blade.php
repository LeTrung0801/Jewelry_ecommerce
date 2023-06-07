<?php 
    if(!empty(Request::old())) {
        $info = Request::old();
    }
?>
@extends('user.layouts.app')
@section('content')
    <div class="info-customer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a href="{{route('user-info')}}" class="nav-link {{$action == 'profile' ? 'active' : ''}}" >Thông tin tài
                            khoản</a>
                        <a href="{{route('user-history-order')}}" class="nav-link {{$action == 'order-history' ? 'active' : ''}}">Lịch sử đơn
                            hàng</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            <h2>Thông tin tài khoản</h2>
                            @include('user.shared.error')
                            <form action="{{route('edit-user-info')}}" method="post">
                              @csrf
                                <div class="row">
                                    <input type="hidden" name="type" value="edit">
                                    <div class="col mb-3">
                                        <input type="text" name="user_name" class="form-control " value="{{ $info['cus_name'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <input type="email" class="form-control" name="user_email" value="{{ $info['cus_email'] ?? '' }}" readonly>
                                    </div>
                                    <div class="col mb-3">
                                        <input type="text" name="user_phone" class="form-control" value="{{ $info['cus_phone'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select class="nice-select w-100 form-control" id="city_selected" name="city">
                                            <option selected>Chọn tỉnh thành</option>
                                            {{-- @foreach ($cities as $city => $value)
                                                <option value="{{ Str::length($city) == 1 ? '0' . $city : $city }}">
                                                    {{ $value }}</option>
                                            @endforeach --}}
                                            @foreach($cities as $value => $name)
                                                <option value="{{$value}}"
                                                {{!empty($info['city_id']) && $value == $info['city_id'] ? 'selected':''}}>
                                                {{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="nice-select w-100 form-control" id="district_selected"
                                            name="district">
                                            <option value="{{ $info->dis_id ?? ''}}">{{$info->getDistrict->name ?? ''}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select class="nice-select w-100 form-control" id="ward_selected" name="ward">
                                            <option value="{{ $info->ward_id ?? ''}}">{{$info->getDistrict->name ?? ''}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control mb-3" id="address" name="cus_add"
                                            placeholder="Địa chỉ" value="{{ $info['cus_add'] ?? '' }}" >
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col mb-3">
                                    <input type="password" name="user_password" class="form-control" placeholder="password hiện tại">
                                  </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col mb-3">
                                        <input type="password" name="new_pwd" class="form-control"
                                            placeholder="password mới">
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <button type="submit" class="btn amado-btn w-100 col-5" >Lưu thông tin</button>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
