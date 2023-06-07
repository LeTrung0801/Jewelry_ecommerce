<?php
	$pageTitle = 'Thêm mới';
    $route = route('admin-account-create');
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.account.form', [
        'route' => $route,
        'formType' => 'create'
    ])
@stop
