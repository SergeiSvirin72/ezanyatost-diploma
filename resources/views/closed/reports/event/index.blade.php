@extends('layouts.closed')
@section('title', 'Традиционные мероприятия')
@section('content')
    <h1>Традиционные мероприятия</h1>
    <form name="fetch" method="post">
        <input type="hidden" name="header">
        <div class="form-group">
            <label>Учреждение</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic dynamic-start">
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
        <div class="form-group form-group-row">
            <input type="date" name="start"
                   value="{{(new DateTime())->modify('-7 day')->format('Y-m-d')}}"
                   class="form-control form-control-block">
            <input type="date" name="end"
                   value="{{(new DateTime())->modify('+7 day')->format('Y-m-d')}}"
                   class="form-control form-control-block" style="margin-left: 8px">
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-search"></i><span>Найти</span>
            </button>
        </div>
        <input type="hidden" id="dynamic-fetch" value="/report/event/fetch">
        @csrf
    </form>

    <div class="table-wrapper">
        <table class="table table-lg table-scroll">
        </table>
    </div>
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
