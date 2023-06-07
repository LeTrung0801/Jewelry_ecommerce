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
                        {{-- <a href="{{route('admin-account-create')}}"><button class="btn btn-primary">Thêm</button></a>
                        <a href="{{route('admin-account-export')}}"><button class="btn btn-primary">Export</button></a> --}}
                    </div>
                </div>
            </div>
            <!-- Datatable start -->
            <div class="card-box mb-30">

                <div class="pb-20">
                    <table class="data-table table table-responsive-xl stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Mã phiếu nhập</th>
                                <th>Nhà cung cấp</th>
                                <th>Tổng Giá</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo phiếu</th>
                                <th>Ngày nhập</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            <tr>
                                <td>
                                    <a href="{{route('admin-warehouse-edit',['pk' => $item['rep_id']])}}">
                                        {{$item->rep_id}} <i class="dw dw-edit2"></i>
                                    </a>
                                </td>
                                <td>
                                    @if (!empty($item->sup_id))
                                        {{$item->supplier->sup_name}}
                                    @endif
                                </td>
                                <td>{{number_format($item->total)}}</td>
                                <td>
                                    @if($item->rep_status==1)
                                    <button type="button" class="btn btn-success lock text-center pt-0 pb-0">
                                        <i class="icon-copy dw dw-checked"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-danger lock text-center pt-0 pb-0">
                                        <i class="icon-copy dw dw-warning"></i>
                                    </button>
                                @endif
                                </td>
                                <td>{{$item->created_at}}</td>
                                @if($item->rep_status==1)
                                <td>{{$item->updated_at}}</td>
                                @else
                                <td></td>
                                @endif
                                {{-- <td>
                                    <button type="button" class="btn btn-success lock text-center pt-0 pb-0">
                                        <i class="icon-copy fa fa-unlock" aria-hidden="true"></i>
                                    </button>
                                </td> --}}
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
