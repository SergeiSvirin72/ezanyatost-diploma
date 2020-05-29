@extends('layouts.closed')
@section('title', 'Объединения')
@section('content')
    <h1>Объединения</h1>
    <div class="form-group">
        <a href="/admin/associations/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить объединение</a>
    </div>

    <form name="fetch">
        @csrf
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="column_name" value="organisations.short_name">
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
                    class="sorting">Наименование <span id="name_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="course"
                    class="sorting">Направление <span id="course_icon"></span></th>
                <th data-sort_type="asc"
                    data-column_name="organisation"
                    class="sorting">Учреждение <span id="organisation_icon"></span></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @include('closed.admin.associations.index_data')
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
