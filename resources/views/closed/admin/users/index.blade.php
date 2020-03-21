@extends('layouts.closed')
@section('title', 'Пользователи')
@section('content')
    <h1>Пользователи</h1>
    <div class="form-group">
        <a href="/admin/users/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить пользователя</a>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
    @endif
    @if(count($users))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="td-center">{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td class="td-center">{{$user->username}}</td>
                        <td class="td-center">{{$user->role}}</td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/users/{{$user->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    @else
        <div>Пользователей пока нет. Добавьте нового пользователя.</div>
    @endif
@endsection
