<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>
    </div>
    <div class="header-right">
        <div class="dashboard-setting user-notification">
            <div class="dropdown">
                <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                    <i class="dw dw-settings2"></i>
                </a>
            </div>
        </div>
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon micon dw dw-user"></span>
                    <span class="user-name">{{Auth::guard('admin')->user()->acc_name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="{{route('admin-profile')}}"><i class="dw dw-user1"></i> Hồ sơ</a>
                    <a class="dropdown-item" href="{{route('admin-logout')}}"><i class="dw dw-logout"></i> Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
</div>
