<?php
	$pageTitle = 'Chỉnh sửa';
    $route = route('admin-category-edit',['pk' => $inputs['cat_id']]);
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.category.form', [
        'route' => $route,
        'formType' => 'edit'
    ])
@stop
