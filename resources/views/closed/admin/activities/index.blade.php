@extends('layouts.closed')
@section('title', 'Объединение - Учреждение')
@section('content')
    <h1>Связь: Объединение - Учреждение</h1>
    <div class="form-group">
        <a href="/admin/activities/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить связь</a>
    </div>

    @if(count($activities))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Объединение</th>
                    <th>Учреждение</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{$activity->id}}</td>
                        <td>{{$activity->association}}</td>
                        <td class="td-center">{{$activity->organisation}}</td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/activities/{{$activity->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $activities->links() }}
    @else
        <div>Связей пока нет. Добавьте новую связь.</div>
    @endif
@endsection
