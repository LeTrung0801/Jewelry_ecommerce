@extends('admin.pages.dashboard')
@section('content')
{{-- <div class="main-container"> --}}
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <form action="{{route('admin-category-list')}}" method="get">
                            <div class="input-group mb-0">
                                <input type="text" name="keyword" class="form-control search-input" placeholder="Search Here">
                                <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="dw dw-search2 search-icon"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{route('admin-category-create')}}"><button class="btn btn-primary">Thêm</button></a>
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
                                <th class="text-nowrap">Thumbnail</th>
                                <th class="text-nowrap">Tên danh mục</th>
                                <th class="text-nowrap">Ngày tạo </th>
                                <th class="text-nowrap">Ngày cập nhật</th>
                                <th class="text-nowrap">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            @php
                                $imgs = [];
                                $path = public_path().'/category-img/'.$item['cat_id'];

                                if ($handle = opendir($path)) {

                                    while (false !== ($entry = readdir($handle))) {
                                        if ($entry != "." && $entry != "..") {
                                            array_push($imgs, $entry);
                                        }
                                    }
                                    closedir($handle);
                                }
                            @endphp
                            <tr>
                                <td class="text-nowrap">
                                    <div class="dt-checkbox">
                                        <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                        <span class="dt-checkbox-label"></span>
                                    </div>
                                </td>
                                <td class="table-plus">
                                    <a><img class="w-25" src="{{ asset('category-img/'.$item['cat_id'].'/'.$imgs[0]) }}">
                                    </a>
                                </td>
                                <td class="table-plus text-nowrap">
                                    <a href="{{ route('admin-category-edit', ['pk' => $item['cat_id']]) }}">{{$item->cat_name}}
                                        <i class="dw dw-edit2"></i>
                                    </a>
                                </td>
                                <td class="table-plus text-nowrap">{{$item->created_at}}</td>
                                <td class="table-plus text-nowrap">{{$item->updated_at}}</td>
                                <td class="table-plus">
                                    @csrf
                                    <a class="need-confirm" confirm-content='Xóa thiệt hả, chắc không ???' confirm-type='delete'
                                        href="{{route('admin-category-delete',['pk' => $item['cat_id']])}}">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @include('admin.shared.paginator',['paginator' => $list])
        </div>
    </div>
{{-- </div> --}}
@endsection
