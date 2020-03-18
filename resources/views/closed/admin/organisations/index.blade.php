@extends('layouts.closed')
@section('title', 'Учреждения')
@section('content')
    <h1>Учреждения</h1>
    <div class="form-group">
        <a href="/admin/organisations/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить учреждение</a>
    </div>

    @if(count($organisations))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($organisations as $organisation)
                    <tr>
                        <td class="td-center">{{$organisation->id}}</td>
                        <td>
                            <a href="/admin/organisations/{{$organisation->id}}"
                               class="link-secondary">{{$organisation->short_name}}</a>
                        </td>
                        <td class="td-center">
                            <a href="/admin/organisations/{{$organisation->id}}/edit"
                               class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a></td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/organisations/{{$organisation->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $organisations->links() }}
    @else
        <div>Учреждений пока нет. Добавьте новое учреждение.</div>
    @endif
@endsection
