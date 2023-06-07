<?php
	$pageTitle = 'Chỉnh sửa';
    $route = route('admin-product-edit',['pk' => $inputs['pro_id']]);
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.product.form', [
        'route' => $route,
        'formType' => 'edit'
    ])
@stop
