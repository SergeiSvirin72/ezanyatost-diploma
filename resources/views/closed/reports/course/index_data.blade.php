<thead>
<tr>
    <th>Направление</th>
    <th>Объединение</th>
    <th>Учреждение</th>
</tr>
</thead>
<tbody>
            @foreach ($associations as $association)
                <tr>
                    <td>{{$association->course}}</td>
                    <td>{{$association->association}}</td>
                    <td>
                        @if($results = findValue([$association->association], ['association'], $organisations))
                            @foreach($results as $result)
                                <span>{{$result->organisation}}</span><br>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
</tbody>
