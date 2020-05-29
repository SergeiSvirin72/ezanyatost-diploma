@extends('layouts.closed')
@section('title', 'Добавить преподавателя')
@section('content')
    <h1>Добавить преподавателя</h1>
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
    <form method="post" action="/admin/teachers">
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
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Учреждение</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic dynamic-start"
                    data-dependant="associations">
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}">
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Объединение</label>
            <select id="associations"
                    name="association_id" class="form-control form-control-block dynamic-end">
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить преподавателя</button>
    </form>

    <div class="section-padding-top">
        <h3>Импорт из файла</h3>
        <form method="post" action="/admin/teachers/import" enctype="multipart/form-data">
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
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
@endsection
