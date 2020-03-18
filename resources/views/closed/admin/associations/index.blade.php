@extends('layouts.closed')
@section('title', 'Объединения')
@section('content')
    <h1>Объединения</h1>
    <div class="form-group">
        <a href="/admin/associations/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить объединение</a>
    </div>

    @if(count($associations))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Направление</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($associations as $association)
                    <tr>
                        <td class="td-center">{{$association->id}}</td>
                        <td>{{$association->name}}</td>
                        <td class="td-center">{{$association->course}}</td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/associations/{{$association->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $associations->links() }}
    @else
        <div>Объединений пока нет. Добавьте новое объединение.</div>
    @endif
@endsection
