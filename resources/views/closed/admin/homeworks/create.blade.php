@extends('layouts.closed')
@section('title', 'Добавить задание')
@section('content')
    <h1>Добавить задание</h1>
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
    <form method="post" action="/admin/homeworks" enctype="multipart/form-data">
        @csrf
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Учреждение</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic dynamic-start"
                    data-dependant="associations">
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}" {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1,2])) form-hidden @endif">
            <label>Объединение</label>
            <select id="associations"
                    name="association_id" class="form-control form-control-block dynamic-end">
            </select>
        </div>
        <div class="form-group">
            <label>Дата</label>
            <input type="date" name="date"
                   value="{{ old('date') ?? (new DateTime())->format('Y-m-d') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Задание</label>
            <textarea name="value" class="form-control form-control-block">{{ old('value') }}</textarea>
        </div>
        <div class="form-group">
            <label>Дополнительные материалы. Допускаются изображения, pdf, файлы Microsoft Office</label>
            <input name="materials[]" type="file" class="form-control-file form-control-block" multiple>
        </div>
        <button type="submit" class="btn btn-success">Добавить задание</button>
    </form>
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
@endsection
