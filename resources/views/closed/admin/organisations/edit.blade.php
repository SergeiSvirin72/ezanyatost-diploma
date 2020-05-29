@extends('layouts.closed')
@section('title', 'Редактировать учреждение')
@section('content')
    <h1>Редактировать учреждение</h1>
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
    <form method="post" action="/admin/organisations/{{ $organisation->id }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>Полное наименование</label>
            <input type="text" name="full_name"
                   value="{{ $organisation->full_name }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Краткое наименование</label>
            <input type="text" name="short_name"
                   value="{{ $organisation->short_name }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Директор</label>
            <select name="director_id" class="form-control form-control-block">
                <option value="">Выберите директора</option>
                @foreach($directors as $director)
                    <option value="{{$director->id}}"
                        {{ ($organisation->director_id == $director->id ? "selected":"") }}>
                        {{$director->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Часы приема</label>
            <input type="text" name="reception"
                   value="{{ $organisation->reception }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Юридический адрес</label>
            <input type="text" name="legal_address"
                   value="{{ $organisation->legal_address }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Фактический адрес</label>
            <input type="text" name="actual_address"
                   value="{{ $organisation->actual_address }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Телефон</label>
            <input type="text" name="phone"
                   value="{{ $organisation->phone }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Факс</label>
            <input type="text" name="fax"
                   value="{{ $organisation->fax }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Электронная почта</label>
            <input type="text" name="email"
                   value="{{ $organisation->email }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Веб-сайт</label>
            <input type="text" name="website"
                   value="{{ $organisation->website }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <input type="checkbox" name="is_school"
                   @if ($organisation->is_school) checked @endif>
            <label class="form-check-label">Это школа?</label>
        </div>
        @isset($organisation->img)
            <div class="img-wrapper">
                <a class="link-primary" target="_blank"
                   href="{{asset('storage/'.$organisation->img)}}">
                    <img src="{{asset('storage/'.$organisation->img)}}">
                </a>
            </div>
        @endisset
        <div class="form-group">
            <label>Изображение</label><br>
            <input name="img" type="file" class="form-control-file">
            <a href="/admin/organisations/{{ $organisation->id }}/delete_image" class="btn btn-danger">
                <i class="fas fa-times"></i>
                <span>Удалить изображение</span>
            </a>
        </div>

        <button type="submit" class="btn btn-success">Редактировать учреждение</button>
    </form>
@endsection
