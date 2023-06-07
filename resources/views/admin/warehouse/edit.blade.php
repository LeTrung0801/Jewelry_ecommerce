<?php
$materials = AppData::material;
?>
@extends('admin.pages.dashboard')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="clearfix">
                <div>
                    <h4 class="text-blue h4 text-center"> NHẬP KHO </h4>
                </div>
            </div>
        </div>
        <!-- Datatable start -->
        <div class="card-box mb-30">
            <div class="pb-20">
                <form action="{{route('admin-warehouse-edit',['pk' => $bill_summary['rep_id']])}}" method="post">
                    @csrf
                    <table class="data-table table table-responsive-xl stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                {{-- <th>Tên sản phẩm</th> --}}
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                {{-- <th>Thành tiền</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0 ; $i<count($input['bill_data']); $i++)
                                <tr class="pro_row" row = "1">
                                    <td>
                                        <input type="text" name="{{'data['.$i.'][pro_id]'}}" value="{{$input['bill_data'][$i]['pro_id']}}" hidden>
                                        {{$input['bill_data'][$i]['pro_id']}}
                                    </td>
                                    {{-- <td>
                                        {{$input['bill_data'][$i]['pro_id']->getProduct->pro_name}}
                                    </td> --}}
                                    <td>
                                        <input type="text" name="{{'data['.$i.'][price]'}}" value="{{$input['bill_data'][$i]['price']}}"n>
                                    </td>
                                    <td>
                                        <input type="text" name="{{'data['.$i.'][quantity]'}}" value="{{$input['bill_data'][$i]['quantity']}}">
                                    </td>
                                    {{-- <td>
                                        <input type="text" name="{{'data['.$i.'][total_price]'}}" value="{{$input['bill_data'][$i]['total_price']}}">
                                    </td> --}}
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    @if ($bill_summary['rep_status'] == 0)
                        <button type="submit" class="btn btn-primary ml-2">Xác nhận</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
