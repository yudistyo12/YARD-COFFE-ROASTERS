@php($product = new \App\Models\Product())
@extends('layouts.app')
@section('title', 'Tambah produk — YARD & COFFEE ROASTERS')
@section('content')
    @include('admin.products.form')
@endsection
