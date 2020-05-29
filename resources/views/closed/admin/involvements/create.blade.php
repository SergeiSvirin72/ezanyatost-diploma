@extends('layouts.closed')
@section('title', 'Добавить вовлеченность')
@section('content')
    <h1>Добавить вовлеченность</h1>
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
    <form method="post" action="/admin/involvements">
        @csrf
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Школа</label>
            <select name="school_id"
                    class="form-control form-control-block dynamic dynamic-start"
                    data-dependant="classes">
                @foreach($schools as $school)
                    <option value="{{$school->id}}" {{ (old('school_id') == $school->id ? "selected":"") }}>
                        {{$school->short_name}}
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
        <div class="form-group">
            <label>Объединение</label>
            <select id="associations"
                    name="association_id" class="form-control form-control-block dynamic-end">
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить вовлеченность</button>
    </form>

    <div class="section-padding-top">
        <h3>Импорт из файла</h3>
        <form method="post" action="/admin/involvements/import" enctype="multipart/form-data">
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
