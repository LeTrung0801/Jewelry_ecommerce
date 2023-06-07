@extends('user.layouts.app')
@section('content')
    <div class="main-content-wrapper d-flex clearfix">
        <div class="amado_product_area amado_product_area_cart section-padding-100 pt-5">
            <div class="container-fluid">
                <div class="cart-table-area section-padding-100">
                    <div class="container-fluid">
                        <div class="cart-title">
                            <h2>Thông tin đặt hàng</h2>
                        </div>
                        @include('user.shared.error')
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="checkout_details_area mt-50 clearfix">
                                    <form action="{{route('order-create')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-2 align-self-center">
                                                <label for="">Tên Người Nhận</label>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <input type="text" class="form-control" id="first_name"
                                                value="{{$customer->cus_name}}"
                                                placeholder="Họ tên" readonly>
                                            </div>
                                            <div class="col-2 align-self-center">
                                                <label for="">Số Điện Thoại</label>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <input type="text" class="form-control" id="phone_number"
                                                value="{{$customer->cus_phone}}"
                                                placeholder="Số điện thoại" readonly>
                                            </div>

                                            @if (!empty($cusAdd))

                                            <div class="col-2 align-self-center">
                                                <label for="">Địa Chỉ Nhận Hàng</label>
                                            </div>
                                            <div class="col-10 mb-3">
                                                <input type="text" class="form-control" name="cus_add"
                                                value="{{$cusAdd}}" readonly>
                                            </div>
                                            <div class="row">
                                                <p class="pt-5" id="change-address"> THAY ĐỔI ĐỊA CHỈ NHẬN HÀNG </p>
                                            </div>

                                            @else
                                            <input type="hidden" name="new_add" value="2">
                                            <div class="col-2 align-self-center">
                                                <label for="">Địa Chỉ Nhận Hàng</label>
                                            </div>
                                            <div class="row col-10 mb-3">
                                                <div class="col-md-6 mb-3">
                                                    <select class="nice-select w-100" id="city_selected" name="city1">
                                                        <option selected>Chọn tỉnh thành</option>
                                                        @foreach ($cities as $city => $value)
                                                        <option value="{{Str::length($city) == 1 ? '0'.$city : $city}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <select class="nice-select w-100" id="district_selected" name="district1">

                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <select class="nice-select w-100" id="ward_selected" name="ward1">

                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <input type="text" class="form-control mb-3" id="address" name="address1"
                                                        placeholder="Địa chỉ" value="">
                                                </div>
                                            </div>    
                                            @endif
                                        </div>

                                        <div class="cus-address row d-none" type = "hiden">
                                            <div class="col-md-6 mb-3">
                                                <select class="nice-select w-100" id="city_selected" name="city">
                                                    <option selected>Chọn tỉnh thành</option>
                                                    @foreach ($cities as $city => $value)
                                                    <option value="{{Str::length($city) == 1 ? '0'.$city : $city}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <select class="nice-select w-100" id="district_selected" name="district">

                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <select class="nice-select w-100" id="ward_selected" name="ward">

                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <input type="text" class="form-control mb-3" id="address" name="address"
                                                    placeholder="Địa chỉ" value="">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="cart-summary">
                                    <h5>Tổng tiền</h5>
                                    <ul class="summary-table">
                                        <li><span>Chi phí vận chuyển:</span>
                                            <span>Free</span>
                                        </li>
                                        <li><span>Thành Tiền:</span>
                                            <h5>{{number_format($total)}}</h5>
                                        </li>
                                    </ul>
                                    <h5 class="mt-2 mb-2">Phương thức thanh toán</h5>
                                    <div class="payment-method">
                                        @foreach ($payment as $key => $value )
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="payment-{{$key}}" name="payment" value="{{$key}}">
                                            <label class="custom-control-label" for="payment-{{$key}}">{{$value}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="cart-btn mt-20">
                                        <button type="submit" class="btn amado-btn w-100">Đặt hàng</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
