@extends('layouts.opened')
@section('title', 'Главная страница')
@section('styles')
    <link href="{{ asset('/css/opened/index.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="section-padding-both">
            <p>Домашняя страница открытой части</p>
        </div>
    </div>
@endsection
