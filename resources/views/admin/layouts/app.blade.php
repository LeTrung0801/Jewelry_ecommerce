<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

    <!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!--Logo-->
    <link rel="shortcut icon" href="{{ asset('html/admin/images/logo/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('html/admin/images/logo/favicon.png') }}" type="image/x-icon">
    <!-- CSS -->
	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{ asset('html/admin/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- Font -->
	<link rel="stylesheet" href="{{ asset('html/admin/plugins/fontawesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('html/admin/css/icon-font.min.css')}}">
    <!-- Template Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('html/admin/css/core.css')}}">
    <!-- Jquery Confirm -->
    <link rel="stylesheet" type="text/css" href="{{asset('html/admin/plugins/jquery-confirm/jquery-confirm.min.css')}}">
    <!-- Main Css -->
    <link rel="stylesheet" href="{{ asset('html/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('html/admin/css/main.css') }}">

</head>
<body>
    @yield('login')

    @if(Auth::guard('admin')->check())
        @yield('dashboard')
    @endif

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Template Js -->
    <script src="{{asset('html/admin/js/core.min.js')}}"></script>
    <script src="{{asset('html/admin/js/script.min.js')}}"></script>
     <!-- JqueryConfirm Js -->
     <script src="{{asset('html/admin/plugins/jquery-confirm/jquery-confirm.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('html/admin/plugins/bootstrap/bootstrap.min.js') }}"></script>
    {{-- <script src="{{asset('html/admin/js/process.js')}}"></script> --}}
    <script src="{{asset('html/admin/js/layout-settings.js')}}"></script>
    {{-- <script src="{{asset('html/admin/js/dashboard.js')}}"></script> --}}

    <!-- Chart Script -->
    {{-- <script src="{{ asset('html/admin/plugins/highcharts-6.0.7/highcharts-more.js') }}"></script> --}}
    <script src="{{ asset('html/admin/plugins/highcharts-6.0.7/highcharts.js') }}"></script>

    <!-- Main Script -->
    <script src="{{ asset('html/admin/js/chart.js') }}"></script>
    <script src="{{ asset('html/admin/js/main.js') }}"></script>

</body>
</html>
