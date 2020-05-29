@foreach($events as $event)
    <tr>
        <td class="td-ellipsis">
            <p><a href="/admin/events/{{$event->id}}"
               class="link-secondary">{{$event->name}}</a></p></td>
        <td class="td-center">{{(new \DateTime($event->date))->format('d.m.Y')}} </td>
        <td class="td-center">{{$event->organisation}}</td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$event->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $events->links() }}</td></tr>
