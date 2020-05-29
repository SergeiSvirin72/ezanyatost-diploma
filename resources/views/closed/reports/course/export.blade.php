<table>
<thead>
<tr><th>Управление образования МО Муравленко</th></tr>
<tr><th><b>Перечень направлений внеурочной деятельности</b></th></tr>
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
    <th style="background-color: #ededed;" width="40"><b>Направление</b></th>
    <th style="background-color: #ededed;" width="40"><b>Объединение</b></th>
    <th style="background-color: #ededed;" width="40"><b>Учреждение</b></th>
</tr>
</thead>
<tbody>
@foreach ($associations as $association)
    <tr>
        <td>{{$association->course}}</td>
        <td>{{$association->association}}</td>
        <td width="50">
            @if($results = findValue([$association->association], ['association'], $organisations))
                @foreach($results as $result)
                    {{$result->organisation}}
                    @if (!$loop->last)
                        <br>
                    @endif
                @endforeach
            @endif
        </td>
    </tr>
@endforeach
</tbody>
</table>
