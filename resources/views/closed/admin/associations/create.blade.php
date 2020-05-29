@extends('layouts.closed')
@section('title', 'Добавить объединение')
@section('content')
    <h1>Добавить объединение</h1>
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
    <form method="post" action="/admin/associations">
        @csrf
        <div class="form-group">
            <label>Наименование</label>
            <input type="text" name="name"
                   value="{{ old('name') }}" class="form-control form-control-block">
        </div>
        <div class="form-group">
            <label>Направление</label>
            <select name="course_id" class="form-control form-control-block">
                @foreach($courses as $course)
                    <option value="{{$course->id}}" {{ (old('course_id') == $course->id ? "selected":"") }}>
                        {{$course->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Учреждение</label>
            <select name="organisation_id" class="form-control form-control-block">
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}"
                        {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить объединение</button>
    </form>
@endsection
