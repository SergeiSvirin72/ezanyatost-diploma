@extends('layouts.closed')
@section('title', 'Преподаватель - Занятие')
@section('content')
    <h1>Связь: Преподаватель - Занятие</h1>
    <div class="form-group">
        <a href="/admin/employments/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить связь</a>
    </div>

    @if(count($employments))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Преподаватель</th>
                    <th>Объединение</th>
                    <th>Учреждение</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($employments as $employment)
                    <tr>
                        <td>{{$employment->id}}</td>
                        <td>{{$employment->teacher}}</td>
                        <td>{{$employment->association}}</td>
                        <td class="td-center">{{$employment->organisation}}</td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/employments/{{$employment->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $employments->links() }}
    @else
        <div>Связей пока нет. Добавьте новую связь.</div>
    @endif
@endsection
