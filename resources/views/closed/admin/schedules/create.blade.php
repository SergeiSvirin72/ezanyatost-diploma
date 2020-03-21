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
        <div class="form-group">
            <label>Преподаватель - занятие</label>
            <select name="employment_id" class="form-control form-control-block">
                @foreach($employments as $employment)
                    <option value="{{$employment->id}}" {{ (old('employment_id') == $employment->id ? "selected":"") }}>
                        {{$employment->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>День недели</label>
            <select name="weekday" class="form-control form-control-block">
                @foreach($weekdays as $dayNumber => $dayName)
                    <option value="{{$dayNumber}}" {{ (old('weekday') == $dayNumber ? "selected":"") }}>
                        {{$dayName}}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить объединение</button>
    </form>
@endsection
