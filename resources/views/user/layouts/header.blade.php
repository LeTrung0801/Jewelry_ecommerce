<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{ asset('html/user/plugins/bootstrap/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('html/user/plugins/jquery-confirm-3.3.2/jquery-confirm.min.css') }}">
	<!-- Themify Icons -->
	<link rel="stylesheet" href="{{ asset('html/user/plugins/themify-icons/themify-icons.css') }}" >
	<link rel="stylesheet" href="{{ asset('html/admin/plugins/fontawesome/css/all.css') }}">
	<!-- Slick -->
	<link rel="stylesheet" href="{{ asset('html/user/plugins/slick/slick.css') }}">
	<link rel="stylesheet" href="{{ asset('html/user/plugins/slick/slick-theme.css') }}">

    <!--Favicon-->
    <link rel="shortcut icon" href="{{ asset('html/user/images/logo/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('html/user/images/logo/favicon.png') }}" type="image/x-icon">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('html/user/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('html/user/css/style.css') }}">
	@yield('css')
</head>
<body>

