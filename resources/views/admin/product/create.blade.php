<?php
	$pageTitle = 'Thêm mới';
    $route = route('admin-product-create');
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.product.form', [
        'route' => $route,
        'formType' => 'create'
    ])
@stop