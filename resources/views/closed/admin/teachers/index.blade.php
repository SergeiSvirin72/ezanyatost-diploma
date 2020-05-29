@extends('layouts.closed')
@section('title', 'Преподаватели')
@section('content')
    <h1>Преподаватели</h1>
    <div class="form-group">
        <a href="/admin/teachers/create"
           class="btn btn-success"><i class="fas fa-plus"></i><span>Добавить преподавателя</span></a>
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

    <div class="table-wrapper table-scroll">
        <table class="table">
            <thead>
            <tr>
                <th data-sort_type="asc"
                    data-column_name="name"
                    class="sorting">Имя <span id="name_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="username"
                    class="sorting">Логин <span id="username_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="association"
                    class="sorting">Объединение <span id="association_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="organisation"
                    class="sorting">Учреждение <span id="organisation_icon"></span></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @include('closed.admin.teachers.index_data')
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
