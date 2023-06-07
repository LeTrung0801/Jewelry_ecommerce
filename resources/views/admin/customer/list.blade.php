<?php
    // $role = AppData::accRole;
?>
@extends('admin.pages.dashboard',[
    'breadcrumbs' => [
		[
			'route' => route('admin-customer-list'),
			'title' => 'Khách Hàng'
		]
	]
])
@section('content')
{{-- <div class="main-container"> --}}
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <form action="{{route('admin-customer-list')}}" method="get">
                            <div class="input-group mb-0">
                                <input type="text" name="keyword" class="form-control search-input" placeholder="Search Here">
                                <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="dw dw-search2 search-icon"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        {{-- <a href="{{route('admin-account-export')}}"><button class="btn btn-primary">Export</button></a>
                        <button class="btn btn-primary">Import</button> --}}
                    </div>
                </div>
            </div>
            <!-- Datatable start -->
            <div class="card-box mb-30">

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
                                <th class="text-nowrap">Email</th>
                                <th class="text-nowrap">SĐT</th>
                                <th class="text-nowrap">Địa chỉ</th>
                                <th class="text-nowrap">Trạng thái</th>
                                <th class="text-nowrap">Xóa</th>
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
                                <td class="table-plus">{{$item->cus_name}}</td>
                                <td>{{$item->cus_email}}</td>
                                <td>{{$item->cus_phone}}</td>
                                <td>{{$item->cus_phone}}</td>
                                <td> {{ csrf_field() }}
                                    @if($item->cus_status==0)
                                    <a type="button" id="btn-{{$item->cus_id}}"
                                        class="btn btn-secondary lock text-center pt-0 pb-0">
                                        <i class="icon-copy fa fa-unlock" aria-hidden="true"></i></a>
                                    @elseif ($item->cus_status==1)
                                    <a type="button" id="btn-{{$item->cus_id}}"
                                        href="{{route('admin-customer-active')}}"
                                        class="btn btn-success lock text-center pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status' confirm-content='Xác nhận khóa tài khoản'
                                        data-id="{{$item->cus_id}}" value="{{$item->cus_status}}">
                                        <i class="icon-copy fa fa-unlock" aria-hidden="true"></i></a>
                                    @else
                                    <a type="button" id="btn-{{$item->cus_id}}"
                                        href="{{route('admin-customer-active')}}"
                                        class="btn btn-danger lock pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status' confirm-content='Xác nhận mở khóa'
                                        data-id="{{$item->cus_id}}" value="{{$item->cus_status}}">
                                        <i class="icon-copy fa fa-lock" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a class="need-confirm" confirm-content='Xóa thiệt hả, chắc không ???' confirm-type='delete'
                                        href="{{route('admin-customer-delete',['pk' => $item['cus_id']])}}">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection
