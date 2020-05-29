<thead>
<tr>
    <th colspan="100%" class="th-left">{{$association->name}} ({{$association->organisation}})</th>
</tr>
<tr>
    <th></th>
    @foreach ($dates as $date)
        <th>{{$date->format('d.m')}}</th>
    @endforeach
</tr>
</thead>
<tbody>
@foreach ($students as $student)
    <tr>
        <td>{{$student->name}}</td>
        @foreach ($dates as $date)
            <td data-user="{{$student->id}}"
                data-date="{{$date->format("Y-m-d")}}"
                data-association="{{$association->id}}"
                class="td-center @if($date >= new DateTime('-2 week') && $date <= new DateTime('+2 week')) editable @else td-disabled @endif"
            >@if($result = findValue([$date->format('Y-m-d'), $student->id], ['date', 'student_id'], $attendances)){{$result[0]->value}}@endif</td>
        @endforeach
    </tr>
@endforeach
</tbody>
<script src="{{ asset('js/editAttendance.js') }}"></script>
