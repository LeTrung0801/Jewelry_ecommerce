@extends('admin.pages.dashboard')
@section('content')
<div class="pd-ltr-20">
    <div class="card-box pd-20 height-100-p mb-30">
        <h2 class="h4 mb-20">KẾT QUẢ KINH DOANH</h2>
        <div class="row">
            <div class="col-xl-4 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data money">
                            <span class="icon-copy fi-dollar"></span>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">DOANH THU</div>
                            <div class="weight-600 font-14 money">{{ number_format($total_price) }}đ</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data order">
                            <span class="icon-copy fi-shopping-bag"></span>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">ĐƠN HÀNG</div>
                            <div class="weight-600 font-14 order">{{ $order }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data user">
                            <span class="icon-copy fi-torsos-all"></span>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">KHÁCH HÀNG</div>
                            <div class="weight-600 font-14 user">{{ $cus }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-box pd-20 height-100-p mb-20">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <form action="{{route('admin-home')}}" method="GET">
                        @csrf
                        <div class="form-row">
                            
                            <div class="form-group col-md-3">
                                <label for="inputState">Tháng</label>
                                <select id="inputState" class="form-control" name="month">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @while ($i < 13)
                                        <option>{{$i}}</option>
                                        @php
                                            ++$i;
                                        @endphp
                                    @endwhile
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputZip">Năm</label>
                                <input type="text" class="form-control" value="2022" name="year">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputZip">Tìm</label>
                                <button class="btn btn-outline-secondary form-control" type="submit"><i class="dw dw-search2 search-icon"></i></button>
                            </div>    
                        </div>
                        

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card-box pd-20 height-100-p mb-20">
        <div class="row sort">
            <div class="col-xl-4 mb-30 ">
                <h2 class="h4">TỔNG QUAN BÁO CÁO</h2>
            </div>
            <div class="col-xl-4 mb-30">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="radio-date" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="radio-date">Ngày</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="radio-month" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="radio-month">Tháng</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="radio-year" name="customRadioInline" class="custom-control-input">
                    <label class="custom-control-label" for="radio-year">Năm</label>
                </div>
            </div>
            <div class="col-xl-4 mb-30">
                <div class="form-group" id="select-date" >
                    <input class="form-control date-picker" placeholder="Chọn Ngày" type="text" name="date"></input>
                </div>   
                <div class="form-group" id="select-month" >
                    <input class="form-control month-picker" placeholder="Chọn Tháng" type="text" name="date"></input>
                </div>    

            </div>
        </div>
    </div>

    <div class="bg-white pd-20 card-box mb-30">
        <div id="chart1"></div>
    </div>

    <div class="bg-white pd-20 card-box mb-30">
        <div id="chart4"></div>
    </div>

    <div class="bg-white pd-20 card-box mb-30">
        <div id="chart5"></div>
    </div> --}}
    
</div>
@endsection
