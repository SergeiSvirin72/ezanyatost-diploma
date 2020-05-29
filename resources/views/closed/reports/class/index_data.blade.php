<thead>
<tr>
    <th>Наименование ОДО</th>
    <th>Общее число</th>
    @for ($i = 1; $i < 12; $i++)
        <th>{{ $i }} класс</th>
    @endfor
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
        @for ($i = 1; $i < 12; $i++)
            <td class="td-center">
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
