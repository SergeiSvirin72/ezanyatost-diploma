@extends('layouts.closed')
@section('title', 'Объединение - Учреждение')
@section('content')
    <h1>Связь: Объединение - Учреждение</h1>
    <div class="form-group">
        <a href="/admin/association-organisation/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить связь</a>
    </div>

    @if(count($relationships))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Объединение</th>
                    <th>Учреждение</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($relationships as $relationship)
                    <tr>
                        <td>{{$relationship->id}}</td>
                        <td>{{$relationship->association}}</td>
                        <td class="td-center">{{$relationship->organisation}}</td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/association-organisation/{{$relationship->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $relationships->links() }}
    @else
        <div>Связей пока нет. Добавьте новую связь.</div>
    @endif
@endsection
