<?php
    if(Session::has('cart')){
        $cart = Session::get('cart');
    }
?>
@include('user.layouts.header')
    <!-- navigation -->
    <header class="navigation fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-white">
                <a class="navbar-brand order-1" href="{{route('user-home')}}">
                <img class="img-fluid" width="100px" src="{{ asset('html/user/images/logo/logo.png') }}"
                    alt="Reader | Hugo Personal Blog Template">
                </a>
                <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user-home')}}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('product-list')}}">Trang sức</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Bộ Sưu Tập</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user-about')}}">Giới Thiệu</i></a>
                        </li>
                    </ul>
                    <form action="{{route('product-list')}}" method="get" accept-charset="utf-8">
						<div class="input-group widget-search">
							<input id="search-query" class="input-search" name="keyword" type="text" placeholder="Tìm kiếm" autocomplete="off">
							<div class="input-group-append">
								<button class="btn btn-secondary search-bar rounded-right" type="submit"></button>
							</div>
						</div>
					</form>
                    <div class="border-0 bg-transparent btn-social">
						<ul class="list-inline footer-list mb-0 d-inline-flex">
							<li class="list-inline-item cart"><a href="{{route('cart') }}">
                                <i class="ti-shopping-cart"></i>
                                <span class="badge" id="count-item" data-count="0"></span>
                            </a>
                            </li>
                            <li class="list-inline-item dropdown">
                                @if (Auth::guard('cus')->check())
                                <a  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-user"></i>
                                    {{Auth::guard('cus')->user()->cus_name}}
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('user-info')}}">Thông Tin </a>
                                    <a class="dropdown-item" href="{{route('user-logout')}}">Đăng Xuất</a>
                                </div>
                                @else
                                    <a  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-user"></i>
                                    </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('user-login')}}">Đăng Nhập </a>
                                    <a class="dropdown-item" href="{{route('user-register')}}">Đăng Ký</a>
                                </div>
                                @endif
                            </li>
						</ul>
					</div>
				</div>
				<button class="navbar-toggler border-0 order-2" type="button" data-toggle="collapse" data-target="#navigation"><i class="ti-menu"></i></button>
            </nav>
        </div>
    </header>

    <div class="container-fluid">
        @yield('content')
        <input type="hidden" name="message"
			value="{{session()->has('message')?session('message'):''}}"/>
		<?php
			if(Session::has('errorMessage')) {
				$errorMessage = Session::get('errorMessage');
			}
		?>
        <input type="hidden"
            value="{{!empty($errorMessage)?$errorMessage:''}}"
            name="error-message"
        />
        <a id="scrollUp" ><i class="ti-angle-double-up"></i></a>
    </div>

    <footer class="footer">
        <svg class="footer-border" height="214" viewBox="0 0 2204 214" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2203 213C2136.58 157.994 1942.77 -33.1996 1633.1 53.0486C1414.13 114.038 1200.92 188.208 967.765 118.127C820.12 73.7483 263.977 -143.754 0.999958 158.899"
            stroke-width="2" />
        </svg>
        <div class="container">
            <img class="img-fluid" width="200px" src="{{ asset('html/user/images/logo/logo.png') }}">
            <div class="row align-items-center pt-3">
                <div class="col-md-5 text-md-left mb-4">
                    <ul class="list-inline footer-list mb-0">
                        <li class="text" >BORCELLE.jewellery.com Vietnam</li>
                        <li>170E Phan Đăng Lưu, P.3, Q.Phú Nhuận, TP.Hồ Chí Minh</li>
                        <li>ĐT: 028 39951703</li>
                        <br>
                        <li>Tổng đài hỗ trợ (08:00-21:00, miễn phí gọi)</li>
                        <li>Gọi mua: 1800545457 (phím 1)</li>
                        <li>Khiếu nại: 1800545457 (phím 2)</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <ul class="list-inline footer-list mb-0">
                        <li class="text" >DỊCH VỤ KHÁCH HÀNG</li>
                        <li><a>Chính sách bảo hành thu đổi</a></li>
                        <li><a>Chính sách giao hàng</a></li>
                        <br>
                        <li class="text" >PHƯƠNG THỨC THANH TOÁN</li>
                        <ul class="list-inline footer-list mb-0">
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/payment/visa.png') }}"></li>
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/payment/dollar.png') }}"></li>
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/payment/credit-card.png') }}"></li>
                        </ul>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <ul class="list-inline footer-list mb-0">
                        <li class="text">KẾT NỐI VỚI CHÚNG TÔI</a></li>
                        <ul class="list-inline footer-list mb-0">
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/media/facebook.png') }}"></li>
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/media/instagram.png') }}"></li>
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/media/twitter.png') }}"></li>
                            <li class="list-inline-item"><img width="50px" src="{{ asset('html/user/images/media/youtube.png') }}"></li>
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="border-bottom border-default"></div>
                <div class="text-center p-3">
                    © 2022 Copyright:
                    <a class="text-dark">BORCELLE.jewellery.com Vietnam</a>
                </div>
            </div>
        </div>
    </footer>
@include('user.layouts.footer')
