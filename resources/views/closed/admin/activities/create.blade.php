@extends('layouts.closed')
@section('title', 'Добавить связь')
@section('content')
    <h1>Добавить связь: Объединение - Учреждение</h1>
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
    <form method="post" action="/admin/activities">
        @csrf
        <div class="form-group">
            <label>Объединение:</label>
            <select name="association_id" class="form-control form-control-block">
                <option value="">Выберите объединение</option>
                @foreach($associations as $association)
                    <option value="{{$association->id}}"
                        {{ (old('association_id') == $association->id ? "selected":"") }}>
                        {{$association->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Учреждение:</label>
            <select name="organisation_id" class="form-control form-control-block">
                <option value="">Выберите учреждение</option>
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}"
                        {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить связь</button>
    </form>
@endsection
