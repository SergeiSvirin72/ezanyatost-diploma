@extends('layouts.closed')
@section('title', 'Вовлеченность')
@section('content')
    <h1>Вовлеченность</h1>
    <div class="form-group">
        <a href="/admin/involvements/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить вовлеченность</a>
    </div>

    <form name="fetch">
        @csrf
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="column_name" value="users.name">
        <input type="hidden" name="sort_type" value="asc">

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
                    data-column_name="organisation"
                    class="sorting">Учреждение <span id="organisation_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="association"
                    class="sorting">Объединение <span id="association_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="student"
                    class="sorting">Обучающийся <span id="student_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="class"
                    class="sorting">Класс <span id="class_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="letter"
                    class="sorting">Буква <span id="letter_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="school"
                    class="sorting">Школа <span id="school_icon"></span></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @include('closed.admin.involvements.index_data')
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
