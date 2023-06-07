@extends('user.layouts.app')
@section('content')

    <div class="main-content-wrapper d-flex clearfix pt-3">
        @include('user.shared.sidebar')
        <div class="amado_product_area section-padding-100 pt-0">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($pro as $item)
                        <!-- Single Product Area -->
                    <div class="col-12 col-sm-6 col-md-4 pt-3">
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                <a href="{{ route('product-detail',['id' => $item->pro_id]) }}">
                                    <img class="first-img" src="{{ asset('product-img/'.$item->pro_id.'/1.png') }}" alt="">
                                    <!-- Hover Thumb -->
                                    <img class="hover-img" src="{{ asset('product-img/'.$item->pro_id.'/2.png') }}" alt="">
                                </a>
                            </div>

                            <!-- Product Description -->
                            <div class="product-description">
                                <!-- Product Meta Data -->
                                <div class="product-meta-data">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="line"></div>
                                            <p class="product-price">
                                                @if (!empty($item->pro_price_sale))
                                                    {{number_format($item->pro_price_sale)}} đ
                                                @else
                                                    {{number_format($item->pro_price)}} đ
                                                @endif
                                            </p>
                                        </div>
                                        <!-- Ratings & Cart -->
                                        <div class="ratings-cart text-right">
                                            <div class="cart">
                                                <a href="{{route('add-cart',['pro_id' => $item->pro_id])}}" data-toggle="tooltip" data-placement="left"
                                                    title="Thêm vào giỏ hàng">
                                                    <img src="{{ asset('html/user/images/payment/cart.png') }}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('product-detail',['id' => $item->pro_id]) }}" class="text-center">
                                        <span>{{$item->pro_name}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @include('user.shared.paginator',['paginator' => $pro])

            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->
@endsection
