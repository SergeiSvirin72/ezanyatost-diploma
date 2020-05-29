@extends('layouts.closed')
@section('title', 'Добавить мероприятие')
@section('content')
    <h1>Добавить мероприятие</h1>
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
    <form method="post" action="/admin/events" enctype="multipart/form-data">
        @csrf
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Учреждение</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic dynamic-start">
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}" {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Дата</label>
            <input type="date" name="date"
                   value="{{ old('date') ?? (new DateTime())->format('Y-m-d') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Заголовок</label>
            <input type="text" name="name"
                   value="{{ old('name') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Содержание</label>
            <textarea name="content" class="form-control form-control-block">{{ old('content') }}</textarea>
        </div>
        <div class="form-group">
            <label>Изображение</label>
            <input name="img" type="file" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-success">Добавить мероприятие</button>
    </form>
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
@endsection
