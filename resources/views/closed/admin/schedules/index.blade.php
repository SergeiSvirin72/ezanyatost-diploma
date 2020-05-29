@extends('layouts.closed')
@section('title', 'Расписания')
@section('content')
    <h1>Расписания</h1>
    <div class="form-group">
        <a href="/admin/schedules/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить расписание</a>
    </div>

    <form name="fetch">
        @csrf
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="column_name" value="weekdays.id">
        <input type="hidden" name="sort_type" value="asc">

        <div class="form-group form-group-row">
            <input type="text" name="search" class="form-control form-control-block" placeholder="Поиск...">
            <button type="submit" name="submit" class="btn btn-primary btn-block">
                <i class="fas fa-search"></i><span>Найти</span>
            </button>
        </div>
    </form>

    <div class="table-wrapper table-scroll">
        <table class="table">
            <thead>
            <tr>
                <th data-sort_type="asc"
                    data-column_name="association"
                    class="sorting">Объединение <span id="association_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="weekdays.id"
                    class="sorting">День недели <span id="weekdays.id_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="start"
                    class="sorting">Начало <span id="start_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="end"
                    class="sorting">Конец <span id="end_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="classroom"
                    class="sorting">Класс <span id="classroom_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="teacher"
                    class="sorting">Преподаватель <span id="teacher_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="organisation"
                    class="sorting">Учреждение <span id="organisation_icon"></span></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @include('closed.admin.schedules.index_data')
            </tbody>
        </table>
        @csrf
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="column_name" value="id">
        <input type="hidden" name="sort_type" value="asc">
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
