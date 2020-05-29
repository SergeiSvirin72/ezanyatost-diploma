@extends('layouts.closed')
@section('title', 'Личный кабинет')
@section('content')
    <h1>Личный кабинет</h1>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <section class="section-padding-bottom">
        <div class="lead">
            <p><b>Ф.И.О: </b><span> {{\Auth::user()->name}}</span></p>
            <p><b>Роль: </b><span> {{$role}}</span></p>
            @switch(\Auth::user()->role_id)
                @case(2)
                    <p><b>Учреждение: </b><span> {{$info->organisation}}</span></p>
                @break

                @case(3)
                    <p><b>Учреждение: </b><span> {{$info->organisation}}</span></p>
                    <p><b>Объединение: </b><span> {{$info->association}}</span></p>
                @break

                @case(5)
                    <p><b>Пол: </b><span> {{$info->gender}}</span></p>
                    <p><b>Учреждение: </b><span> {{$info->organisation}}</span></p>
                    <p><b>Класс: </b><span> {{$info->class}}{{$info->letter}}</span></p>
                    <p><b>Статус: </b>
                        @forelse($info->statuses as $status)
                            <span>{{$status}}@if(!$loop->last),@endif</span>
                        @empty
                            <span>Нет</span>
                        @endforelse
                    </p>
                @break
            @endswitch
        </div>
    </section>
    <section class="home-form">
        <h3>Добавить электронную почту</h3>
        <form method="POST" action="/home/email">
            @if ($errors->first('email'))
                <div class="alert alert-danger">
                    {{$errors->first('email')}}
                </div>
            @endif
                @if (session('success_email'))
                    <div class="alert alert-success">
                        {{ session('success_email') }}
                    </div>
                @endif
            @csrf
            <div class="form-group">
                <input type="text" name="email"
                       value="{{ old('email', \Auth::user()['email']) }}"
                       class="form-control form-control-block"
                        placeholder="Электронная почта">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-primary" value="Добавить">
            </div>
        </form>
    </section>
    <section class="home-form">
        <h3>Изменить пароль</h3>
        <form method="POST" action="/home/password">
            @if ($errors->first('password') || $errors->first('password_confirmation'))
                <div class="alert alert-danger">
                    {{$errors->first('password') ? $errors->first('password') : $errors->first('password_confirmation')}}
                </div>
            @endif
            @if (session('success_password'))
                <div class="alert alert-success">
                    {{ session('success_password') }}
                </div>
            @endif
            @csrf
            <div class="form-group">
                <input type="password" name="password" class="form-control form-control-block"
                       placeholder="Пароль">
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control form-control-block"
                       placeholder="Подтверждение пароля">
            </div>
            <div class="form-group">
                <button type="submit" name="auth_submit" class="btn btn-outline-primary">Изменить</button>
            </div>
        </form>
    </section>
@endsection
