@extends('layouts.closed')
@section('title', 'Добавить расписание')
@section('content')
    <h1>Добавить расписание</h1>
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
    <form method="post" action="/admin/schedules">
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
        <div class="form-group">
            <label>Объединение</label>
            <select id="associations"
                    name="association_id"
                    class="form-control form-control-block dynamic"
                    data-dependant="teachers">
            </select>
        </div>
        <div class="form-group">
            <label>Преподаватель</label>
            <select id="teachers"
                    name="teacher_id" class="form-control form-control-block dynamic-end">
            </select>
        </div>
        <div class="form-group">
            <label>День недели</label>
            <select name="weekday_id" class="form-control form-control-block">
                @foreach($weekdays as $weekday)
                    <option value="{{$weekday->id}}" {{ (old('weekday_id') == $weekday->id ? "selected":"") }}>
                        {{$weekday->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Время начала</label>
            <input type="time" name="start"
                   value="{{old('start') ?? '00:00'}}"
                   class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Время окончания</label>
            <input type="time" name="end"
                   value="{{old('start') ?? '00:00'}}"
                   class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Учебная аудитория</label>
            <input type="text" name="classroom"
                   value="{{ old('classroom') }}" class="form-control form-control-block">
        </div>
        <button type="submit" class="btn btn-success">Добавить расписание</button>
    </form>

    <div class="section-padding-top">
        <h3>Импорт из файла</h3>
        <form method="post" action="/admin/schedules/import" enctype="multipart/form-data">
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
