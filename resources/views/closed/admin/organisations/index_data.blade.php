@foreach($organisations as $organisation)
    <tr>
        <td>
            <a href="/admin/organisations/{{$organisation->id}}"
               class="link-secondary">{{$organisation->short_name}}</a>
        </td>
        <td class="td-center">
            <a href="/admin/organisations/{{$organisation->id}}/edit"
               class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
        </td>
        <td class="td-center">
            <a href="javascript:void(0);"
               class="btn btn-sm btn-danger delete"
               data="{{$organisation->id}}"><i class="fas fa-times"></i></a>
        </td>
    </tr>
@endforeach
<tr><td class="td-pagination">{{ $organisations->links() }}</td></tr>
