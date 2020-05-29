@foreach($schedules as $schedule)
    <tr>
        <td>{{$schedule->association}}</td>
        <td class="td-center">{{$schedule->weekday}}</td>
        <td class="td-center">{{(new \DateTime($schedule->start))->format('H:i')}}</td>
        <td class="td-center">{{(new \DateTime($schedule->end))->format('H:i')}}</td>
        <td class="td-center">{{$schedule->classroom}}</td>
        <td class="td-center">{{formatName($schedule->teacher)}}</td>
        <td class="td-center">{{$schedule->organisation}}</td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$schedule->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $schedules->links() }}</td></tr>
