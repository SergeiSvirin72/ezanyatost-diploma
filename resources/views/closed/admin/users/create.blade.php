@extends('layouts.closed')
@section('title', 'Добавить пользователя')
@section('content')
    <h1>Добавить пользователя</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
    @endif
    <form method="post" action="/admin/users">
        @csrf
        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="first_name"
                   value="{{ old('first_name') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="username"
                   value="{{ old('username') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Электронная почта</label>
            <input type="text" name="email"
                   value="{{ old('email') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password"
                   class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Подтверждение пароля</label>
            <input type="password" name="password_confirmation"
                   class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Роль</label>
            <select name="role_id" class="form-control form-control-block">
                @foreach($roles as $role)
                    <option value="{{$role->id}}" {{ (old('role_id') == $role->id ? "selected":"") }}>
                        {{$role->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить пользователя</button>
    </form>
@endsection
