@extends('layouts.closed')
@section('title', 'Мероприятия')
@section('content')
    <h1>Мероприятия</h1>
    <div class="form-group">
        <a href="/admin/events/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить мероприятие</a>
    </div>
    <form name="fetch">
        @csrf
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="column_name" value="date">
        <input type="hidden" name="sort_type" value="desc">
        <input type="hidden" name="begin">
        <div class="form-group form-group-row">
            <input type="date" name="start"
                   value="{{(new DateTime())->modify('-7 day')->format('Y-m-d')}}"
                   class="form-control form-control-block">
            <input type="date" name="end"
                   value="{{(new DateTime())->modify('+7 day')->format('Y-m-d')}}"
                   class="form-control form-control-block" style="margin-left: 8px">
        </div>
        <div class="form-group form-group-row">
            <input type="text" name="search" class="form-control form-control-block" placeholder="Поиск...">
            <button type="submit" name="submit" class="btn btn-primary btn-block">
                <i class="fas fa-search"></i><span>Найти</span>
            </button>
        </div>
    </form>

    <div class="table-wrapper">
        <table class="table table-scroll">
            <thead>
            <tr>
                <th data-sort_type="asc"
                    data-column_name="name"
                    class="sorting">Заголовок <span id="name_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="date"
                    class="sorting">Дата <span id="date_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="organisation"
                    class="sorting">Учреждение <span id="organisation_icon"></span></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @include('closed.admin.events.index_data')
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
