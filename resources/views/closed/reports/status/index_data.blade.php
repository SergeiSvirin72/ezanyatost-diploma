<thead>
<tr>
    <th>Наименование ОДО</th>
    <th>Общее число</th>
    @foreach ($statuses as $status)
        <th>{{ $status->name }}</th>
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
