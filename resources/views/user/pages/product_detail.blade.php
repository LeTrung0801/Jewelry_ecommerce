@extends('user.layouts.app')
@section('content')
    <div class="main-content-wrapper d-flex clearfix pt-3">
        @include('user.shared.sidebar')
        <div class="amado_product_area section-padding-100 pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0"
                                        style="background-image: url({{ asset('product-img/' . $pro->pro_id . '/1.png') }});">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="1"
                                        style="background-image: url({{ asset('product-img/' . $pro->pro_id . '/2.png') }});">
                                    </li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="">
                                            <img class="d-block w-100"
                                                src="{{ asset('product-img/' . $pro->pro_id . '/1.png') }}" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="">
                                            <img class="d-block w-100"
                                                src="{{ asset('product-img/' . $pro->pro_id . '/2.png') }}" alt="Second slide">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <a href="product-details.html">
                                    <h6>{{ $pro->pro_name }}</h6>
                                </a>
                                <p class="product-price pt-1">
                                    @if (!empty($pro->pro_price_sale))
                                        {{ number_format($pro->pro_price_sale) }} đ
                                    @else
                                        {{ number_format($pro->pro_price) }} đ
                                    @endif
                                </p>
                            </div>

                            <div class="short_overview my-5">
                                <p>{{ $pro->pro_description }}</p>
                            </div>

                            <!-- Add to Cart Form -->
                            <form action="{{route('add-cart', ['pro_id' => $pro->pro_id])}}" class="cart clearfix" method="get">
                                <div class="qty-detail d-flex mb-50">
                                    {{-- <p>Số lượng</p> --}}
                                    <div class="quantity d-flex">
                                        <button class="btn btn-primary minus rounded-0 is-form" type="button">
                                            <i class="fas fa-minus"></i></button>
                                        <input aria-label="quantity" class="input-qty"
                                            name="qty" type="number" min="1" max="100" value="1">
                                        <button class="btn btn-primary plus rounded-0 is-form" type="button">
                                            <i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <button type="submit" class="btn amado-btn btn-add-cart">Thêm vào giỏ hàng</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="best_sale pt-5">
                    <div class="section_title">
                        <h3>Sản Phẩm Liên Quan</h3>
                    </div>
                    <div class="multiple-relative">
                        @foreach ($re_pro as $re_products)
                        <!-- Single Product Area -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                <a href="{{ route('product-detail',['id' => $re_products->pro_id ]) }}">
                                    <img class="first-img" src="{{ asset('product-img/'.$re_products->pro_id.'/1.png') }}" alt="">
                                    <!-- Hover Thumb -->
                                    <img class="hover-img" src="{{ asset('product-img/'.$re_products->pro_id.'/2.png') }}" alt="">
                                </a>
                            </div>

                            <!-- Product Description -->
                            <div class="product-description">
                                <!-- Product Meta Data -->
                                <div class="product-meta-data text-center">
                                    <a href="{{ route('product-detail',['id' => $re_products->pro_id ]) }}">
                                        <span>{{$re_products->pro_name}}</span>
                                    </a>
                                    <p class="product-price pt-2">
                                        @if (!empty($re_products->pro_price_sale))
                                            {{number_format($re_products->pro_price_sale)}} đ
                                        @else
                                            {{number_format($re_products->pro_price)}} đ
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->
@endsection
