@extends('layouts.opened')
@section('title', 'Восстановление пароля')
@section('styles')
    <link href="{{ asset('/css/opened/auth.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="auth section-padding-both">
        <img src="{{ asset('/images/logo.png') }}">
        <h2>Восстановление пароля</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{$errors->first()}}
                </div>
            @endif
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="fas fa-user"></i></div>
                    <input id="email"
                           type="email"
                           class="form-control"
                           name="email"
                           value="{{ $email ?? old('email') }}"
                           placeholder="Электронная почта">

                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="fas fa-lock"></i></div>
                    <input id="password" type="password" class="form-control" name="password"
                           placeholder="Новый пароль">
                </div>
            </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><i class="fas fa-lock"></i></div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               placeholder="Подтверждение пароля">
                    </div>
                </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary">
                    {{ __('Восстановить пароль') }}
                </button>
            </div>
        </form>
    </section>
@endsection
