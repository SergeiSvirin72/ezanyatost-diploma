<table>
<thead>
<tr><th>Управление образования МО Муравленко</th></tr>
<tr><th><b>Охват дополнительным образованием по классам</b></th></tr>
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

<tr>
    <th style="background-color: #ededed;" width="40"><b>Наименование ОДО</b></th>
    <th style="background-color: #ededed;" width="15"><b>Общее число</b></th>
    @for ($i = 1; $i < 12; $i++)
        <th style="background-color: #ededed;"><b>{{ $i }} класс</b></th>
    @endfor
</tr>
</thead>
<tbody>
@foreach ($organisations as $organisation)
    <tr>
        <td >{{$organisation->short_name}}</td>
        <td>
            @if($result = findValue([$organisation->id], ['organisation'], $reportAll))
                {{$result[0]->count}}
            @else
                {{'0'}}
            @endif
        </td>
        @for ($i = 1; $i < 12; $i++)
            <td>
                @if($result = findValue([$i, $organisation->id], ['class', 'organisation'], $report))
                    {{$result[0]->count}}
                @else
                    {{'0'}}
                @endif
            </td>
        @endfor
    </tr>
@endforeach
</tbody>
</table>
