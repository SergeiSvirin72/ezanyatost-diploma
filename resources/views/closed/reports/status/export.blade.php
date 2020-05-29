<table>
<thead>
<tr><th>Управление образования МО Муравленко</th></tr>
<tr><th><b>Охват дополнительным образованием по статусам</b></th></tr>
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
    @foreach ($statuses as $status)
        <th style="background-color: #ededed;" width="15"><b>{{ $status->name }}</b></th>
    @endforeach
</tr>
</thead>
<tbody>
@foreach ($organisations as $organisation)
    <tr>
        <td>{{$organisation->short_name}}</td>
        <td class="td-center">
            @if($result = findValue([$organisation->id], ['organisation'], $reportAll))
                {{$result[0]->count}}
            @else
                {{'0'}}
            @endif
        </td>
        @foreach ($statuses as $status)
            <td class="td-center">
                @if($result = findValue([$status->id, $organisation->id], ['status', 'organisation'], $report))
                    {{$result[0]->count}}
                @else
                    {{'0'}}
                @endif
            </td>
        @endforeach
    </tr>
@endforeach
</tbody>
</table>
