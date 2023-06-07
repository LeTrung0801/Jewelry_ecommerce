@extends('user.layouts.app')
@section('content')
    <div class="main-content-wrapper d-flex clearfix">
        <div class="amado_product_area amado_product_area_cart section-padding-100 pt-5">
            <div class="container-fluid">
                <div class="cart-table-area section-padding-100">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                                if(Session::has('cart')){
                                    $cart = Session::get('cart');
                                    $tong = 0;
                            ?>
                            <div class="col-12 col-lg-8">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Sản phẩm</th>
                                                <th>Đơn giá</th>
                                                <th>Số lượng</th>
                                                <th>Thành Tiền</th>
                                                <th>Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                            @foreach ($cart as $item)
                                            <?php $tong+= $item['sum']; ?>
                                            <tr>
                                                <td class="cart_product_img">
                                                    <a href="{{route('product-detail',['id' => $item['id']])}}">
                                                        <img src="{{ asset('product-img/'.$item['id'].'/1.png') }}" alt="Product" class="w-50">
                                                    </a>
                                                </td>
                                                <td>

                                                    <div class="product-img-content flex-column">
                                                        <div class="name">
                                                            <p>{{$item['name']}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{number_format($item['price'])}}</td>
                                                <td>
                                                    <div class="qty">
                                                        {{ csrf_field() }}
                                                    <div class="qty-btn d-flex">
                                                        <div class="quantity d-flex">
                                                            <button class="btn btn-primary minus rounded-0 is-form" type="button"><i class="fas fa-minus"></i></button>
                                                            <input aria-label="quantity" class="input-qty"
                                                            url="{{route('change-cart', ['pk' => $item['id']])}}"
                                                            name="qty" type="number" min="1" max="100" value="{{$item['qty']}}">
                                                            <button class="btn btn-primary plus rounded-0 is-form" type="button"><i class="fas fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-center" id="sum-{{$item['id']}}">{{number_format($item['sum'])}}</p>
                                                </td>
                                                <td>
                                                    <a href="{{route('delete-item-cart', ['pk' => $item['id']])}}"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{route('product-list')}}" class="btn btn-primary">Tiếp tục mua hàng</a>
                                    <a href="{{route('delete-cart')}}" class="btn btn-primary">Xóa hết</a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="cart-summary">
                                    <h4 class="text-center">Thông Tin</h4>
                                    <form action="{{ route('checkout') }}" method="get">
                                        <ul class="summary-table">
                                            <li>
                                                <h5>Tổng tiền: </h5>
                                                <p class="subtotal text-right">{{number_format($tong)}}</p>
                                            </li>
                                            <input class="add-total" type="text" hidden>
                                            {{-- <li>
                                                <textarea class="form-control" name="note" id="note" rows="4" placeholder="Ghi chú"></textarea>
                                            </li> --}}
                                        </ul>
                                        <div class="cart-btn mt-20">
                                            <button type="submit" class="btn amado-btn w-100">Đặt hàng</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                                }else {
                            ?>
                                <div class="no-cart w-100 text-center">
                                    <p class="m-5">Giỏ hàng của bạn chưa có sản phẩm</p>
                                </div>
                                <div class="w-100 text-center pt-5">
                                    <a href="{{route('product-list')}}" class="btn btn-primary">Tiếp tục mua hàng</a>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->
@endsection
