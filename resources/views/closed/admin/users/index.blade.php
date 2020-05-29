@extends('layouts.closed')
@section('title', 'Пользователи')
@section('content')
    <h1>Пользователи</h1>
    <div class="form-group">
        <a href="/admin/users/create"
           class="btn btn-success"><i class="fas fa-plus"></i><span>Добавить пользователя</span></a>
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
                    data-column_name="name"
                    class="sorting">Имя <span id="name_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="username"
                    class="sorting">Логин <span id="username_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="role"
                    class="sorting">Роль <span id="role_icon"></span></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @include('closed.admin.users.index_data')
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
