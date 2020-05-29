@foreach($homeworks as $homework)
    <tr>
        <td class="td-pre td-ellipsis"><p><a href="/admin/homeworks/{{$homework->id}}"
                                             class="link-secondary">{{$homework->homework}}</a></p></td>
        <td class="td-center">{{(new \DateTime($homework->date))->format('d.m.Y')}}</td>
        <td class="td-center">{{$homework->association}}</td>
        <td class="td-center">{{$homework->organisation}} </td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$homework->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $homeworks->links() }}</td></tr>
