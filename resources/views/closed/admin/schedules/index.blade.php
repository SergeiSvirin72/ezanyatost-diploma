@extends('layouts.closed')
@section('title', 'Расписания')
@section('content')
    <h1>Расписания</h1>
    <div class="form-group">
        <a href="/admin/schedules/create"
           class="btn btn-success"><i class="fas fa-plus"></i> Добавить расписание</a>
    </div>

    @if(count($schedules))
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Объединение</th>
                    <th>Учреждение</th>
                    <th>День недели</th>
                    <th>Начало</th>
                    <th>Конец</th>
                    <th>Преподаватель</th>
                    <th>Класс</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td class="td-center">{{$schedule->id}}</td>
                        <td class="td-center">{{$schedule->association}}</td>
                        <td class="td-center">{{$schedule->organisation}}</td>
                        <td class="td-center">{{$weekdays[$schedule->weekday]}}</td>
                        <td class="td-center">{{$schedule->start}}</td>
                        <td class="td-center">{{$schedule->end}}</td>
                        <td class="td-center">{{$schedule->teacher}}</td>
                        <td class="td-center">{{$schedule->classroom}}</td>
                        <td class="td-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                 this.nextElementSibling.submit();"
                               class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                            <form action="/admin/schedules/{{$schedule->id}}" method="post" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $schedules->links() }}
    @else
        <div>Расписаний пока нет. Добавьте новое расписание.</div>
    @endif
@endsection
