@extends('admin.pages.dashboard')
@section('content')
{{-- <div class="main-container"> --}}
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="input-group mb-0">
                            <input type="text" class="form-control search-input" placeholder="Search Here">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="dw dw-search2 search-icon"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-primary">Thêm</button>
                        <button class="btn btn-primary">Export</button>
                        <button class="btn btn-primary">Import</button>
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
                                <th class="table-plus datatable-nosort sorting">Tên</th>
                                <th>Giá</th>
                                <th>Giá sale</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Mô tả</th>
                                <th>Thumnail</th>
                                <th>Danh mục</th>
                                <th>Chất liệu</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="dt-checkbox">
                                        <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                        <span class="dt-checkbox-label"></span>
                                    </div>
                                </td>
                                <td class="table-plus">Gloria F. Mead</td>
                                <td>25</td>
                                <td>Sagittarius</td>
                                <td>2829 Trainer Avenue Peoria, IL 61602 </td>
                                <td>29-03-2018</td>
                                <td>25</td>
                                <td>Sagittarius</td>
                                <td>2829 Trainer Avenue Peoria, IL 61602 </td>
                                <td>29-03-2018</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection
