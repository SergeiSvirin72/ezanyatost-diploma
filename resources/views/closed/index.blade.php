@extends('layouts.closed')

@section('content')
    <p>Домашняя страница закрытой части</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <pre>{{print_r($user['role'], true)}}</pre>
@endsection
