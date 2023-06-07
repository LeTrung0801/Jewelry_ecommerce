<?php 
    function getImg($path){
        $imgs = [];
        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    array_push($imgs, $entry);
                }
            }
            closedir($handle);
        }
        return $imgs;
    }
?>
@extends('user.layouts.app')
@section('content')

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img class="d-block w-100" src="{{ asset('html/user/images/slider/1.jpg') }}" alt="First slide">
        </div>
        <div class="carousel-item">
        <img class="d-block w-100" src="{{ asset('html/user/images/slider/2.jpg') }}" alt="Second slide">
        </div>
        <div class="carousel-item">
        <img class="d-block w-100" src="{{ asset('html/user/images/slider/3.jpg') }}" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="row banner-head">
    <div class="col-lg-4">
        <img class="d-block w-100" src="{{ asset('html/user/images/banner/1.jpg') }}">
    </div>
    <div class="col-lg-4">
        <img class="d-block w-100" src="{{ asset('html/user/images/banner/2.jpg') }}">
    </div>
    <div class="col-lg-4">
        <img class="d-block w-100" src="{{ asset('html/user/images/banner/3.jpg') }}">
    </div>
</div>
<div class="container">
    <div class="slider">
        <div class="section_title text-center">
            <h3>Xu hướng tìm kiếm</h3>
        </div>
        <div class="multiple-category">
            @foreach ($cat as $item)
            @php
                $path = public_path().'/category-img/'.$item['cat_id'];
                $img = getImg($path);
            @endphp
            <div class="item">
                <div class="product-img">
                    <a href="{{route('product-list',['cat' => $item->cat_id])}}"><img class="lazy" src="{{ asset('category-img/'.$item->cat_id.'/'.$img[0]) }}"></a>
                </div>
                <div class="product-title">
                    <h5><a href="{{route('product-list',['cat' => $item->cat_id])}}">{{$item->cat_name}}</a></h5>
                </div>
            </div>
            @endforeach
            @foreach ($col as $item)
            @php
                $path = public_path().'/collect-img/'.$item['collect_id'];
                $img = getImg($path);
            @endphp
            <div class="item">
                <div class="product-img">
                    <a href="{{route('product-list',['col' => $item->collect_id])}}"><img class="lazy" src="{{ asset('collect-img/'.$item->collect_id.'/'.$img[0]) }}"></a>
                </div>
                <div class="product-title">
                    <h5><a href="{{route('product-list',['col' => $item->collect_id])}}">{{$item->collect_name}}</a></h5>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="best_sale pt-5">
        <div class="section_title text-center">
            <h3>Sản Phẩm Bán Chạy</h3>
        </div>
        <div class="multiple-items">
            @foreach ($pronew as $item)
            @php
                $path = public_path().'/product-img/'.$item['pro_id'];
                $img = getImg($path);
            @endphp
            <!-- Single Product Area -->
            <div class="single-product-wrapper">
                <!-- Product Image -->
                <div class="product-img">
                    <a href="{{ route('product-detail',['id' => $item->pro_id ]) }}">
                        <img class="first-img" src="{{ asset('product-img/'.$item->pro_id.'/'.$img[0]) }}" alt="">
                        <!-- Hover Thumb -->
                        <img class="hover-img" src="{{ asset('product-img/'.$item->pro_id.'/'.$img[1]) }}" alt="">
                    </a>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data text-center">
                        <a href="{{ route('product-detail',['id' => $item->pro_id ]) }}">
                            <span>{{$item->pro_name}}</span>
                        </a>
                        <p class="product-price pt-2">
                            @if (!empty($item->pro_price_sale))
                                {{number_format($item->pro_price_sale)}} đ
                            @else
                                {{number_format($item->pro_price)}} đ
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="poster pt-5">
        <img src="{{ asset('html/user/images/slider/5.jpg') }}">
    </div>

    <div class="best_sale pt-5">
        <div class="section_title text-center">
            <h3>Sản Phẩm Cưới</h3>
        </div>
        <div class="d-flex">
            <div class="imgCollection col-lg-4">
                <img src="{{ asset('html/user/images/banner/10.png') }}">
            </div>
            <div class="col-lg-8 align-self-center">
                <div class="multiple-product">
                    @foreach ($procol as $item)
                    @php
                        $path = public_path().'/product-img/'.$item['pro_id'];
                        $img = getImg($path);
                    @endphp
                    <!-- Single Product Area -->
                    <div class="single-product-wrapper">
                        <!-- Product Image -->
                        <div class="product-img">
                            <a href="{{ route('product-detail',['id' => $item->pro_id ]) }}">
                                <img class="first-img" src="{{ asset('product-img/'.$item->pro_id.'/'.$img[0]) }}" alt="">
                                <!-- Hover Thumb -->
                                <img class="hover-img" src="{{ asset('product-img/'.$item->pro_id.'/'.$img[1]) }}" alt="">
                            </a>
                        </div>

                        <!-- Product Description -->
                        <div class="product-description">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data text-center">
                                <a href="{{ route('product-detail',['id' => $item->pro_id ]) }}">
                                    <span>{{$item->pro_name}}</span>
                                </a>
                                <p class="product-price pt-2">
                                    @if (!empty($item->pro_price_sale))
                                        {{number_format($item->pro_price_sale)}} đ
                                    @else
                                        {{number_format($item->pro_price)}} đ
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

    <div class="poster pt-5">
        <img src="{{ asset('html/user/images/slider/6.jpg') }}">
    </div>

    <div class="best_sale pt-5">
        <div class="section_title text-center">
            <h3>Sản Phẩm Mới</h3>
        </div>
        <div class="multiple-items">
            @foreach ($pronew as $item)
            @php
                $path = public_path().'/product-img/'.$item['pro_id'];
                $img = getImg($path);
            @endphp
            <!-- Single Product Area -->
            <div class="single-product-wrapper">
                <!-- Product Image -->
                <div class="product-img">
                    <a href="{{ route('product-detail',['id' => $item->pro_id ]) }}">
                        <img class="first-img" src="{{ asset('product-img/'.$item->pro_id.'/'.$img[0]) }}" alt="">
                        <!-- Hover Thumb -->
                        <img class="hover-img" src="{{ asset('product-img/'.$item->pro_id.'/'.$img[1]) }}" alt="">
                    </a>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <!-- Product Meta Data -->
                    <div class="product-meta-data text-center">
                        <a href="{{ route('product-detail',['id' => $item->pro_id ]) }}">
                            <span>{{$item->pro_name}}</span>
                        </a>
                        <p class="product-price pt-2">
                            @if (!empty($item->pro_price_sale))
                                {{number_format($item->pro_price_sale)}} đ
                            @else
                                {{number_format($item->pro_price)}} đ
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

@endsection
