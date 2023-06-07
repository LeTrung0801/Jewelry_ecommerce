@extends('admin.pages.dashboard')
@section('content')
<!-- Default Basic Forms Start -->
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box mb-30 form">
        <div class="clearfix">
            <div>
                <h4 class="text-blue h4 text-center">Tạo mới</h4>
            </div>
        </div>
        <form>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Phân loại</label>
                <div class="col-sm-12 col-md-10">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <select class=" form-control" data-style="btn-outline-primary" data-size="5">
                                <option disabled selected>Danh mục</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <select class=" form-control" data-style="btn-outline-primary" data-size="5">
                                <option disabled selected>Chất liệu</option>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tên sản phẩm</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" placeholder="Tên">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Giá</label>
                <div class="col-sm-12 col-md-10">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <input class="form-control" type="number" placeholder="Giá">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input class="form-control" type="number" placeholder="Giá sale">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Số lượng</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="number" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Thumbnail</label>
                <div class="col-sm-12 col-md-10">
                    <input type="file" class="form-control-file form-control height-auto">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Hình Ảnh</label>
                <div class="col-sm-12 col-md-10">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <input type="file" class="form-control-file form-control height-auto">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="file" class="form-control-file form-control height-auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Mô tả</label>
                <div class="col-sm-12 col-md-6">
                    <textarea class="form-control"></textarea>
                </div>
            </div>
            <button class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
<!-- Default Basic Forms End -->
@endsection
