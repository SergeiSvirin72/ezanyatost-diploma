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
            <label>Направление:</label>
            <select name="course_id" class="form-control form-control-block">
                @forelse($courses as $course)
                    <option value="{{$course->id}}" {{ (old('course_id') == $course->id ? "selected":"") }}>
                        {{$course->name}}
                    </option>
                @empty
                    <option selected disabled>Направлений пока нет</option>
                @endforelse
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить объединение</button>
    </form>
@endsection
