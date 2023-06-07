
<?php
$order_status = AppData::order_status;
$user = Auth::guard('cus')->user();
?>
@extends('user.layouts.app')
@section('content')
    <div class="info-customer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a href="{{route('user-info')}}" class="nav-link {{$action == 'profile' ? 'active' : ''}}" >Thông tin tài
                            khoản</a>
                        <a href="{{route('user-history-order')}}" class="nav-link {{$action == 'order-history' ? 'active' : ''}}">Lịch sử đơn
                            hàng</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <h2>Lịch sử mua hàng</h2>
                            <div class="table-order">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Mã Đơn Hàng</th>
                                            <th scope="col">Ngày Đặt</th>
                                            <th scope="col">Tổng Tiền</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Chi Tiết</th>
                                            <th scope="col">Xác Nhận/Hủy</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $stt = 0;
                                        @endphp
                                        @foreach ($list as $item)
                                            <tr>
                                                <th scope="row">{{ ++$stt }}</th>
                                                <td>{{ $item->o_id }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td> {{ number_format($item->total) }}</td>
                                                <td>
                                                    {{ $order_status[$item->o_status] }}
                                                </td>
                                                <td id = "btn-view-order">
                                                  <button type="submit" class="btn btn-dark"  
                                                    data-toggle="modal" data-target="#exampleModal"
                                                    order-id = " {{ $item->o_id }}"
                                                    getUrlHistory = "{{route('user-order-detail',['o_id' => $item->o_id])}}" >
                                                      Xem
                                                  </button>
                                                  @csrf
                                                </td>
                                                @if ($item->o_status == 0)
                                                <td>
                                                  <a href="{{route('user-order-status')}}" class="btn btn-danger need-confirm" confirm-type = 'change-status-order' confirm-content='Bạn có chắc muốn hủy đơn hàng này' data-id="{{ $item->o_id }}">HỦY</a>
                                                </td>
                                                @elseif ($item->o_status == 1)
                                                <td>
                                                  <a href="{{route('user-order-status')}}" class="btn btn-success need-confirm" confirm-type = 'change-status-order' confirm-content='Xác nhận đã nhận được hàng' data-id="{{ $item->o_id }}">ĐÃ NHẬN</a>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('user.user-info.order-detail')               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
