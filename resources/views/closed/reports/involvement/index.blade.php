@extends('layouts.closed')
@section('title', 'Расписание')
@section('content')
    <h1>Расписание</h1>
    <div class="table-wrapper">
        <table class="table table-lg table-scroll table-valign">
            <thead>
            <tr><th class="th-left" colspan="3">{{$student->name}}, {{$student->class}}-{{$student->letter}} ({{$student->organisation}})</th></tr>
            <tr>
                <th>Наименование ОДО</th>
                <th>Объединение</th>
                <th>Время занятий</th>
            </tr>
            </thead>
            <tbody>
            @forelse($associations as $association)
                <tr>
                    <td>{{$association->organisation}}</td>
                    <td>{{$association->association}}</td>
                    <td>
                        @if($results = findValue([$association->id], ['association'], $schedules))
                            @foreach($results as $result)
                                <span>{{substr($result->start, 0, 5)}} - {{substr($result->end, 0, 5)}} {{$result->weekday}}</span><br>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Обучающийся не вовлечен во внеурочную деятельность</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
