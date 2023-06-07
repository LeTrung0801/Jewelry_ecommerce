<?php
	$pageTitle = 'Chỉnh sửa';
    $route = route('admin-account-edit',['pk' => $inputs['acc_id']]);
?>
@extends('admin.pages.dashboard',[
    'breadcrumbs' => [
		[
			'route' => route('admin-account-list'),
			'title' => 'Nhân Viên'
		],[
			'route' => $route,
			'title' => 'Chỉnh sửa'
		]
	]
])

@section('title', $pageTitle)

@section('content')
    @include('admin.account.form', [
        'route' => $route,
        'formType' => 'edit'
    ])
@stop
