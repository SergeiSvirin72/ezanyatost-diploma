@extends('layouts.closed')
@section('title', 'Посещаемость по школьникам')
@section('content')
    <h1>Посещаемость по школьникам</h1>
    <form name="fetch" method="post" action="/report/attendance/export">
        <input type="hidden" name="header">
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
                    name="student_id" class="form-control form-control-block dynamic-fetch dynamic-end">
            </select>
        </div>
        <div class="form-group form-group-row">
            <input type="date" name="start"
                   value="{{(new DateTime())->modify('-14 day')->format('Y-m-d')}}"
                   class="form-control form-control-block">
            <input type="date" name="end"
                   value="{{(new DateTime())->modify('+14 day')->format('Y-m-d')}}"
                   class="form-control form-control-block" style="margin-left: 8px">
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-search"></i><span>Найти</span>
            </button>
        </div>

        <input type="hidden" id="dynamic-fetch" value="/report/student/fetch">
        @csrf
        <div class="form-group">
            <button type="submit" name="export" class="btn btn-info"><i class="fas fa-upload"></i><span>Экспорт в файл</span></button>
        </div>
    </form>

    <div class="table-wrapper">
        <table class="table table-lg table-scroll">
        </table>
    </div>
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
