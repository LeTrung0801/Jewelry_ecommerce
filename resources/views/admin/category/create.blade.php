<?php
	$pageTitle = 'Thêm mới';
    $route = route('admin-category-create');
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.category.form', [
        'route' => $route,
        'formType' => 'create'
    ])
@stop
