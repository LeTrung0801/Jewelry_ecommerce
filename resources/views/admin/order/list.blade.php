<?php
    $role = AppData::accRole;
?>
@extends('admin.pages.dashboard')
@section('content')
{{-- <div class="main-container"> --}}
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <form action="{{route('admin-order-list')}}" method="get">
                            @csrf
                            <div class="input-group mb-0">
                                <input type="text" name="keyword" class="form-control search-input" placeholder="Search Here">
                                <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="dw dw-search2 search-icon"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="col-md-6 col-sm-12 text-right">
                        <a href=""><button class="btn btn-primary">Export</button></a>
                        <button class="btn btn-primary">Import</button>
                    </div> --}}
                </div>
            </div>
            <!-- Datatable start -->
            <div class="card-box mb-30">

                <div class="pb-20">
                    <table class="data-table table table-responsive-xl stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>
                                <div class="dt-checkbox">
                                    <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                    <span class="dt-checkbox-label"></span>
                                </div>
                                </th>
                                <th class="text-nowrap">Mã hóa đơn</th>
                                <th class="text-nowrap">Mã khách hàng</th>
                                <th class="text-nowrap">Địa chỉ khách hàng</th>
                                <th class="text-nowrap">Tổng</th>
                                <th class="text-nowrap">Trạng thái</th>
                                <th class="text-nowrap">Hủy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            <tr>
                                <td>
                                    <div class="dt-checkbox">
                                        <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                        <span class="dt-checkbox-label"></span>
                                    </div>
                                </td>
                                <td class="table-plus">
                                    <a href="{{route('admin-order-detail',['o_id' => $item->o_id])}}"
                                        class="check-order-detail"    
                                        type="submit"
                                        data-toggle="modal" data-target="#exampleModal"
                                        order-id = " {{ $item->o_id }}">{{$item->o_id}}
                                        <i class="dw dw-edit2"></i>
                                    </a>
                                </td>
                                <td>{{$item->cus_id}}</td>
                                <td>{{$item->o_add}}</td>
                                <td>{{ number_format($item->total)}}</td>
                                <td>
                                    @csrf
                                    @if ($item->o_status == 0)
                                    <a type="button" id="btn-{{ $item->o_id }}"
                                        href="{{route('admin-order-status')}}"
                                        class="btn btn-danger lock pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status-order' confirm-content='Xác nhận đơn hàng'
                                        data-id="{{ $item->o_id }}" value="{{ $item->o_status }}">
                                        <i class="icon-copy fa fa-xmark" aria-hidden="true"></i></a>
                                    @else
                                    <a type="button" id="btn"
                                        class="btn btn-success lock text-center pt-0 pb-0">
                                        <i class="icon-copy fa fa-check" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a class="need-confirm" confirm-content='Hủy đơn hàng, chắc không ???' confirm-type='delete'
                                        href="{{route('admin-order-delete', ['pk' => $item->o_id])}}">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">CHI TIẾT ĐƠN HÀNG: </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="order-info">
                                
                                </div>
                                <table class="table order-detail">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Sản phẩm</th>
                                            <th scope="col">Đơn giá</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
{{-- </div> --}}
@endsection
