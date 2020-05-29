@extends('layouts.closed')
@section('title', 'Добавить обучающегося')
@section('content')
    <h1>Добавить обучающегося</h1>
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
    <form method="post" action="/admin/students">
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
            <label>Пол</label>
            <select name="gender_id" class="form-control form-control-block">
                @foreach($genders as $gender)
                    <option value="{{$gender->id}}" {{ (old('gender_id') == $gender->id ? "selected":"") }}>
                        {{$gender->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Класс</label>
            <input type="text" name="class"
                   value="{{ old('class') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Буква</label>
            <input type="text" name="letter"
                   value="{{ old('letter') }}" class="form-control form-control-block">
        </div>
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif"">
            <label>Учреждение</label>
            <select name="organisation_id" class="form-control form-control-block">
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}" {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить обучающегося</button>
    </form>

    <div class="section-padding-top">
        <h3>Импорт из файла</h3>
        <form method="post" action="/admin/students/import" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input name="file" type="file" class="form-control-file">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-upload"></i><span>Импорт из файла</span>
                </button>
            </div>
        </form>
    </div>
@endsection
