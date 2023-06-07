<?php
    $material = AppData::material;
?>
@extends('admin.pages.dashboard')
@section('content')
{{-- <div class="main-container"> --}}
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <form action="{{route('admin-product-list')}}" method="get">
                            <div class="input-group mb-0">
                                <input type="text" name="keyword" class="form-control search-input" placeholder="Search Here">
                                <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="dw dw-search2 search-icon"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{route('admin-product-create')}}"><button class="btn btn-primary">Thêm</button></a>
                        <a href="{{route('admin-product-export')}}"><button class="btn btn-primary">Export</button></a>
                        {{-- <a href="{{route('admin-warehouse-create')}}"><button class="btn btn-primary">Nhập Hàng</button></a> --}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 category">
                        <div class="d-flex justify-content-between">
                            <span class="title">Lựa chọn theo phân loại</span>
                            <button class="btn" type="button" data-toggle="collapse" data-target="#collapseCollection" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="collapseCollection" class="collapse">
                            <form action="{{route('admin-product-list')}}" method="post">
                                @csrf
                                <div class="row">
                                    <ul class="navbar-nav col-md-4">
                                        @foreach ($category as $cate)
                                        <li class="nav-item">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input name="cate-{{$cate->cat_id}}" type="checkbox" class="custom-control-input" id="cat-{{$cate->cat_id}}">
                                                <label class="custom-control-label" for="cat-{{$cate->cat_id}}">{{$cate->cat_name}}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <ul class="navbar-nav col-md-4">
                                        @foreach ($collection as $collect)
                                        <li class="nav-item">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input name="collect-{{$collect->collect_id}}" type="checkbox" class="custom-control-input" id="{{$collect->collect_id}}">
                                                <label class="custom-control-label" for="{{$collect->collect_id}}">{{$collect->collect_name}}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <ul class="navbar-nav col-md-4">
                                        @foreach ($material as $index => $mat)
                                        <li class="nav-item">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input name="material-{{$index}}" type="checkbox" class="custom-control-input" id="{{$mat}}">
                                                <label class="custom-control-label" for="{{$mat}}">{{$mat}}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Datatable start -->
            <div class="card-box mb-30">
                <form action="{{route('admin-warehouse-add')}}" method="post">
                    {{ csrf_field() }}
                <div class="pb-20">
                    <table class="data-table table table-responsive stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>
                                <div class="dt-checkbox">
                                    <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                    <span class="dt-checkbox-label"></span>
                                </div>
                                </th>
                                <th class="text-nowrap">Tên</th>
                                <th class="text-nowrap">Giá Gốc</th>
                                <th class="text-nowrap">Giá Sale</th>
                                <th class="text-nowrap">Số Lượng</th>
                                <th class="text-nowrap">Chất Liệu</th>
                                <th class="text-nowrap">Loại Sản Phẩm</th>
                                <th class="text-nowrap">Dòng Sản Phẩm</th>
                                {{-- <th class="text-nowrap">Trạng thái</th> --}}
                                <th class="text-nowrap">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox mb-5">
										<input type="checkbox" class="custom-control-input" id="pro-{{$item->pro_id}}" name="{{$item->pro_id}}">
										<label class="custom-control-label" for="pro-{{$item->pro_id}}"></label>
									</div>
                                </td>
                                <td class="table-plus" >
                                    <a  href="{{route('admin-product-edit',['pk' => $item->pro_id])}}">
                                        {{$item->pro_name}}<i class="dw dw-edit2"></i>
                                    </a>
                                </td>
                                <td>{{number_format($item->pro_price)}}</td>
                                <td>{{number_format($item->pro_price_sale)}}</td>
                                <td>{{$item->pro_qty}}</td>
                                <td>{{$material[$item->m_id]}}</td>
                                <td>{{$item->category->cat_name}}</td>
                                <td>
                                    @if (!empty($item->pro_collect_id))
                                        {{$item->collection->collect_name}}
                                    @endif
                                </td>
                                {{-- <td>

                                    @if ($item->pro_status == 0)
                                    <a type="button" id="btn"
                                        href="{{route('admin-account-active')}}"
                                        class="btn btn-success lock text-center pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status' confirm-content='Xác nhận khóa tài khoản'
                                        data-id="" value="">
                                        <i class="icon-copy fa fa-check" aria-hidden="true"></i></a>
                                    @else
                                    <a type="button" id="btn"
                                        href="{{route('admin-account-active')}}"
                                        class="btn btn-danger lock pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status' confirm-content='Xác nhận mở khóa'
                                        data-id="" value="">
                                        <i class="icon-copy fa fa-xmark" aria-hidden="true"></i></a>
                                    @endif
                                </td> --}}
                                <td>
                                    <a class="need-confirm" confirm-content='Xóa thiệt hả, chắc không ???' confirm-type='delete'
                                        href="{{route('admin-product-delete',['pk' => $item->pro_id])}}">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">Nhập Hàng</button>
            </form>
            </div>
            @include('admin.shared.paginator',['paginator' => $list])

        </div>
    </div>
{{-- </div> --}}
@endsection
