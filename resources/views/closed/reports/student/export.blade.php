<table>
<thead>
<tr><th>Управление образования МО Муравленко</th></tr>
<tr><th><b>Охват дополнительным образованием по обучающися</b></th></tr>
<tr></tr>

<tr>
    <th><b>Дата:</b></th>
    <th>{{(new \DateTime())->setTimezone(new DateTimeZone('Europe/Moscow'))->format('d.m.Y H:i:s')}}</th>
</tr>
<tr>
    <th><b>Пользователь:</b></th>
    <th>{{\Auth::user()['name']}}</th>
</tr>
<tr></tr>

<tr><th colspan="3">{{$student->name}}, {{$student->class}}-{{$student->letter}} ({{$student->organisation}})</th></tr>
<tr>
    <th style="background-color: #ededed;" width="40"><b>Наименование ОДО</b></th>
    <th style="background-color: #ededed;" width="40"><b>Объединение</b></th>
    <th style="background-color: #ededed;" width="30"><b>Время занятий</b></th>
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
                    {{substr($result->start, 0, 5)}} - {{substr($result->end, 0, 5)}} {{$result->weekday}}
                    @if (!$loop->last)
                        <br>
                    @endif
                @endforeach
            @endif
        </td>
    </tr>
@empty
    <tr><td colspan="3">Обучающийся не вовлечен во внеурочную деятельность</td></tr>
@endforelse
</tbody>
</table>
