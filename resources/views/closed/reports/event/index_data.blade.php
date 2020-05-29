<thead>
<tr>
    <th>Учреждение</th>
    <th>Дата</th>
    <th>Мероприятие</th>
</tr>
</thead>
<tbody>
@foreach ($events as $event)
    <tr>
        <td>{{$event->organisation}}</td>
        <td>{{(new \DateTime($event->date))->format('d.m.Y')}}</td>
        <td class="td-ellipsis">
            <p><a href=/events/{{$event->id}}"
                  class="link-secondary">{{$event->name}}</a></p></td>
    </tr>
@endforeach
</tbody>
