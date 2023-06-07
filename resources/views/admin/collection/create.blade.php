<?php
	$pageTitle = 'Thêm mới';
    $route = route('admin-collection-create');
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.collection.form', [
        'route' => $route,
        'formType' => 'create'
    ])
@stop