@extends('layouts.closed')
@section('title', 'Учреждения')
@section('content')
    <h1>Учреждения</h1>
    <div class="form-group">
        <a href="/admin/organisations/create"
           class="btn btn-success"><i class="fas fa-plus"></i><span>Добавить учреждение</span></a>
    </div>

    <form name="fetch">
        @csrf
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="column_name" value="id">
        <input type="hidden" name="sort_type" value="asc">
    </form>

    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th data-sort_type="asc"
                    data-column_name="short_name"
                    class="sorting">Наименование <span id="short_name_icon"></span></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @include('closed.admin.organisations.index_data')
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/fetchData.js') }}"></script>
@endsection
