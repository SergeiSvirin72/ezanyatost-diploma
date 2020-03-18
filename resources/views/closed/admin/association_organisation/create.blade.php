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
    <form method="post" action="/admin/association-organisation">
        @csrf
        <div class="form-group">
            <label>Объединение:</label>
            <select name="association_id" class="form-control form-control-block">
                @forelse($associations as $association)
                    <option value="{{$association->id}}"
                        {{ (old('association_id') == $association->id ? "selected":"") }}>
                        {{$association->name}}
                    </option>
                @empty
                    <option selected disabled>Объединений пока нет</option>
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <label>Учреждение:</label>
            <select name="organisation_id" class="form-control form-control-block">
                @forelse($organisations as $organisation)
                    <option value="{{$organisation->id}}"
                        {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @empty
                    <option selected disabled>Учреждений пока нет</option>
                @endforelse
            </select>
        </div>
        <button type="submit" class="btn btn-success">Добавить связь</button>
    </form>
@endsection
