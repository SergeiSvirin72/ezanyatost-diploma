@extends('layouts.closed')
@section('title', 'Охват дополнительным образованием по классам')
@section('content')
    <h1>Охват дополнительным образованием по классам</h1>
    <form name="fetch" method="post" action="/report/class/export">
        <input type="hidden" name="header">
        <div class="form-group @if(!in_array(\Auth::user()->role_id, [1])) form-hidden @endif">
            <label>Учреждение</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic dynamic-start dynamic-end">
                @if ($all)
                    <option value="">Все</option>
                @endif
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}" {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" id="dynamic-fetch" value="/report/class/fetch">
        <div class="form-group">
            <button type="submit" name="export" class="btn btn-info"><i class="fas fa-upload"></i><span>Экспорт в файл</span></button>
        </div>
        @csrf
    </form>
    <div class="table-wrapper">
        <table class="table table-lg table-scroll">

        </table>
    </div>
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
@endsection
