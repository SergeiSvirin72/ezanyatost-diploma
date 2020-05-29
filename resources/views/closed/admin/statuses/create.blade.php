@extends('layouts.closed')
@section('title', 'Добавить статус')
@section('content')
    <h1>Добавить статус</h1>
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
    <form method="post" action="/admin/statuses">
        @csrf
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Учреждение</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic dynamic-start"
                    data-dependant="classes">
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}" {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Класс</label>
            <select id="classes"
                    name="class"
                    class="form-control form-control-block dynamic"
                    data-dependant="letters">
            </select>
        </div>
        <div class="form-group">
            <label>Буква</label>
            <select id="letters"
                    name="letter"
                    class="form-control form-control-block dynamic"
                    data-dependant="students">
            </select>
        </div>
        <div class="form-group">
            <label>Обучающийся</label>
            <select id="students"
                    name="student_id" class="form-control form-control-block dynamic-end">
            </select>
        </div>
        <div class="form-group">
            <label>Статус</label>
            <select name="status_id" class="form-control form-control-block">
                @foreach($statuses as $status)
                    <option value="{{$status->id}}" {{ (old('status_id') == $status->id ? "selected":"") }}>
                        {{$status->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить связь</button>
    </form>

    <div class="section-padding-top">
        <h3>Импорт из файла</h3>
        <form method="post" action="/admin/statuses/import" enctype="multipart/form-data">
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
