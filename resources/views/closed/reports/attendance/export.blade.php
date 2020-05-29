<table>
    <thead>
    <tr><th>Управление образования МО Муравленко</th></tr>
    <tr><th><b>Посещаемость по школьникам</b></th></tr>
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
        <th>{{$student->name}}, {{$student->class}}-{{$student->letter}} ({{$student->organisation}})</th>
    </tr>
    <tr>
        <th width="40"></th>
        @foreach ($dates as $date)
            <th style="background-color: #ededed;">{{$date->format('d/m')}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($associations as $association)
        <tr>
            <td width="50">{{$association->name}}<br>{{$association->organisation}}</td>
            @foreach ($dates as $date)
                <td>
                    @if($result = findValue([$date->format('Y-m-d'), $association->id], ['date', 'association_id'], $attendances))
                        {{$result[0]->value}}
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
