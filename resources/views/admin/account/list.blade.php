<?php
    $role = AppData::accRole;
?>
@extends('admin.pages.dashboard',[
    'breadcrumbs' => [
		[
			'route' => route('admin-account-list'),
			'title' => 'Nhân Viên'
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
                        <form action="{{route('admin-account-list')}}" method="get">
                            <div class="input-group mb-0">
                                <input type="text" name="keyword" class="form-control search-input" placeholder="Search Here">
                                <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="dw dw-search2 search-icon"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{route('admin-account-create')}}"><button class="btn btn-primary">Thêm</button></a>
                        <a href="{{route('admin-account-export')}}"><button class="btn btn-primary">Export</button></a>
                        {{-- <button class="btn btn-primary">Import</button> --}}
                    </div>
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
                                <th>Tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            @if($item->acc_id == Auth::guard('admin')->user()->acc_id)
                            <tr>
                                <td>#</td>
                                <td class="table-plus">
                                    {{$item->acc_name}}
                                </td>
                                <td>{{$item->acc_email}}</td>
                                <td>{{$item->acc_phone}}</td>
                                <td>{{$role[$item->acc_role]}}</td>
                                <td>
                                    <button type="button" class="btn btn-success lock text-center pt-0 pb-0">
                                        <i class="icon-copy fa fa-unlock" aria-hidden="true"></i>
                                    </button>
                                </td>
                                <td>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td>
                                    <div class="dt-checkbox">
                                        <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                        <span class="dt-checkbox-label"></span>
                                    </div>
                                </td>
                                <td class="table-plus">
                                    <a  href="{{route('admin-account-edit',['pk' => $item['acc_id']])}}">
                                        {{$item->acc_name}} <i class="dw dw-edit2"></i>
                                    </a>
                                </td>
                                <td>{{$item->acc_email}}</td>
                                <td>{{$item->acc_phone}}</td>
                                <td>{{$role[$item->acc_role]}}</td>
                                <td>
                                    {{ csrf_field() }}
                                    @if ($item->acc_status==1)
                                    <a type="button" id="btn-{{$item->acc_id}}"
                                        href="{{route('admin-account-active')}}"
                                        class="btn btn-success lock text-center pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status' confirm-content='Xác nhận khóa tài khoản'
                                        data-id="{{$item->acc_id}}" value="{{$item->acc_status}}">
                                        <i class="icon-copy fa fa-unlock" aria-hidden="true"></i></a>
                                    @else
                                    <a type="button" id="btn-{{$item->acc_id}}"
                                        href="{{route('admin-account-active')}}"
                                        class="btn btn-danger lock pt-0 pb-0 need-confirm"
                                        confirm-type = 'change-status' confirm-content='Xác nhận mở khóa'
                                        data-id="{{$item->acc_id}}" value="{{$item->acc_status}}">
                                        <i class="icon-copy fa fa-lock" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a class="need-confirm" confirm-content='Xóa thiệt hả, chắc không ???' confirm-type='delete'
                                        href="{{route('admin-account-delete',['pk' => $item['acc_id']])}}">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection
