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
                <label class="col-sm-12 col-md-2 col-form-label">Chức vụ</label>
                <div class="col-sm-12 col-md-10">
                    <select class=" form-control" data-style="btn-outline-primary" data-size="5">
                        <option></option>
                        <option>Mustard</option>
                        <option>Ketchup</option>
                        <option>Relish</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Tên nhân viên</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="text" placeholder="Tên">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="email" placeholder="Tên">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Phone</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="tel" placeholder="Tên">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Password</label>
                <div class="col-sm-12 col-md-10">
                    <input class="form-control" type="password" placeholder="Tên">
                </div>
            </div>
            <button class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
<!-- Default Basic Forms End -->
@endsection
