@extends('layouts.opened')
@section('title', 'Восстановление пароля')
@section('styles')
    <link href="{{ asset('/css/opened/auth.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="auth section-padding-both">
        <img src="{{ asset('/images/logo.png') }}">
        <h2>Восстановление пароля</h2>
        <form method="POST" action="{{ route('password.email') }}">
            @error('email')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><i class="fas fa-envelope"></i></div>
                    <input id="email"
                           type="text"
                           class="form-control"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Электронная почта">
                </div>
            </div>

            <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary">
                        {{ __('Восстановить пароль') }}
                    </button>
            </div>
        </form>
    </section>

{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Reset Password') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <form method="POST" action="{{ route('password.email') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Send Password Reset Link') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
