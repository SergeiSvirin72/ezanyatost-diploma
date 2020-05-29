@extends('layouts.closed')
@section('title', 'Добавить учреждение')
@section('content')
    <h1>Добавить учреждение</h1>
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
    <form method="post" action="/admin/organisations" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Полное наименование</label>
            <input type="text" name="full_name"
                   value="{{ old('full_name') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Краткое наименование</label>
            <input type="text" name="short_name"
                   value="{{ old('short_name') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Директор</label>
            <select name="director_id" class="form-control form-control-block">
                @foreach($directors as $director)
                    <option value="{{$director->id}}" {{ (old('director_id') == $director->id ? "selected":"") }}>
                        {{$director->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Часы приема</label>
            <input type="text" name="reception"
                   value="{{ old('reception') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Юридический адрес</label>
            <input type="text" name="legal_address"
                   value="{{ old('legal_address') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Фактический адрес</label>
            <input type="text" name="actual_address"
                   value="{{ old('actual_address') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Телефон</label>
            <input type="text" name="phone"
                   value="{{ old('phone') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Факс</label>
            <input type="text" name="fax"
                   value="{{ old('fax') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Электронная почта</label>
            <input type="text" name="email"
                   value="{{ old('email') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Веб-сайт</label>
            <input type="text" name="website"
                   value="{{ old('website') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <input type="checkbox" name="is_school" {{ old('is_school') ? 'checked' : ''}}>
            <label class="form-check-label">Это школа?</label>
        </div>
        <div class="form-group">
            <label>Изображение</label>
            <input name="img" type="file" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success">Добавить учреждение</button>
    </form>
@endsection
