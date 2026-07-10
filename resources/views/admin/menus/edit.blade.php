@extends('layouts.app')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')
    @include('admin.menus.create', ['menu' => $menu, 'categories' => $categories])
@endsection
