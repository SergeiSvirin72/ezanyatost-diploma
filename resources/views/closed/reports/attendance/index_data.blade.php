<thead>
<tr>
    <th colspan="100%" class="th-left">{{$student->name}}, {{$student->class}}-{{$student->letter}} ({{$student->organisation}})</th>
</tr>
<tr>
    <th></th>
    @foreach ($dates as $date)
{{--        <th>{{(new \DateTime($date))->format('d.m')}}</th>--}}
        <th>{{$date->format('d.m')}}</th>
    @endforeach
</tr>
</thead>
<tbody>
@foreach ($associations as $association)
    <tr>
        <td>{{$association->name}}<br>{{$association->organisation}}</td>
        @foreach ($dates as $date)
            <td class="td-center">
                @if($result = findValue([$date->format('Y-m-d'), $association->id], ['date', 'association_id'], $attendances))
                    {{$result[0]->value}}
                @endif
            </td>
        @endforeach
    </tr>
@endforeach
</tbody>
<script src="{{ asset('js/editAttendance.js') }}"></script>
