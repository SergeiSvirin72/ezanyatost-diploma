@foreach($students as $student)
    <tr>
        <td>{{$student->name}}</td>
        <td class="td-center">{{$student->username}}</td>
        <td class="td-center">{{$student->gender}}</td>
        <td class="td-center">{{$student->class}}</td>
        <td class="td-center">{{$student->letter}}</td>
        <td class="td-center">{{$student->organisation}}</td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$student->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $students->links() }}</td></tr>
