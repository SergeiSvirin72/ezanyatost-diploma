@foreach($statuses as $status)
    <tr>
        <td>{{$status->name}}</td>
        <td class="td-center">{{$status->class}}</td>
        <td class="td-center">{{$status->letter}}</td>
        <td class="td-center">{{$status->status}}</td>
        <td class="td-center">{{$status->organisation}}</td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$status->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $statuses->links() }}</td></tr>
