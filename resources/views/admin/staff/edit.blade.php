@extends('layouts.app')

@section('title', 'Edit Staf')
@section('page-title', 'Edit Staf')

@section('content')
    @include('admin.staff.create', ['staff' => $staff])
@endsection
