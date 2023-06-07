<?php
	$pageTitle = 'Chỉnh sửa';
    $route = route('admin-collection-edit',['pk' => $inputs['collect_id']]);
?>
@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('admin.collection.form', [
        'route' => $route,
        'formType' => 'edit'
    ])
@stop