@foreach($teachers as $teacher)
    <tr>
        <td>{{$teacher->name}}</td>
        <td class="td-center">{{$teacher->username}}</td>
        <td class="td-center">{{$teacher->association}}</td>
        <td class="td-center">{{$teacher->organisation}}</td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$teacher->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $teachers->links() }}</td></tr>
