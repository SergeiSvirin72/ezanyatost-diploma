@extends('layouts.opened')
@section('title', 'Авторизация')
@section('styles')
    <link href="{{ asset('/css/opened/auth.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="auth section-padding-both">
        <img src="{{ asset('/images/logo.png') }}">
        <h2>Авторизация</h2>
        <form method="POST" action="{{ route('login') }}">
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{$errors->first()}}
                </div>
            @endif
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="fas fa-user"></i></div>
                    <input type="text"
                           name="username"
                           value="{{ old('username') }}"
                           class="form-control"
                           placeholder="Логин">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="fas fa-lock"></i></div>
                    <input type="password" name="password" class="form-control" placeholder="Пароль">
                </div>
            </div>
{{--                <div class="form-group">--}}
{{--                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                    <label>{{ 'Запомнить меня?' }}</label>--}}
{{--                </div>--}}
            <div class="form-group">
                <button type="submit" name="auth_submit" class="btn btn-outline-primary">Войти</button>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-primary">Забыли пароль?</a>
            @endif
        </form>
    </section>
@endsection
