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
                <?php
                     if(Session::has('pro')){
                        $pro = Session::get('pro');
                ?>
                <form action="{{route('admin-warehouse-create')}}" method="post">
                    @csrf
                    <span>Nhà cung cấp</span>
                    <select class=" form-control" data-style="btn-outline-primary" name="sup_id">
                        <option selected disabled>Vui lòng chọn --</option>
                        @foreach($supplier as $key => $value)
                        <option value="{{$value->sup_id}}">{{$value->sup_name}}</option>
                        @endforeach
                    </select>
                    <table class="data-table table table-responsive-xl stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>MÃ SẢN PHẨM</th>
                                <th>TÊN SẢN PHẨM</th>
                                <th>SỐ LƯỢNG</th>
                                <th>XÓA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 0;
                            ?>
                            @foreach ($pro as $item)
                            <tr class="pro_row" row = "1">
                                <td>
                                    <input type="text" name="pro[{{$count}}][id]" value="{{$item['id']}}" hidden>
                                    {{$item['id']}}
                                </td>
                                <td style="word-break: break-all">
                                    <input type="text" name="pro[{{$count}}][name]" value="{{$item['name']}}" hidden>
                                    {{$item['name']}}
                                </td>
                                <td>
                                    <input type="number" name="pro[{{$count}}][qty]">
                                </td>
                                <td>
                                    <a href="{{route('admin-warehouse-delete-item', ['pk' => $item['id']])}}"><i class="dw dw-delete-3"></i></a>
                                </td>
                            </tr>
                            <?php
                                $count++;
                            ?>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary ml-2">LƯU</button>
                </form>
                <?php
                    }else {
                ?>
                <div class="no-cart w-100 text-center">
                    <p class="m-5">Chưa có thông tin sản phẩm cần nhập</p>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

@endsection
