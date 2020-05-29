@foreach($users as $user)
    <tr>
        <td>{{$user->name}}</td>
        <td class="td-center">{{$user->username}}</td>
        <td class="td-center">{{$user->role}}</td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$user->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $users->links() }}</td></tr>
