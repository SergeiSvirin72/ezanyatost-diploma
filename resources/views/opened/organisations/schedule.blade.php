@if(count($schedules))
    @foreach($weekdays as $weekday)
        <div class="card table-item">
            <div class="card-header">
                <b class="table-day">{{$weekday->name}}</b>
            </div>
            @foreach($schedules as $schedule)
                @if ($schedule->day === $weekday->id)
                    <div class="card-body">
                        <b class="table-time">{{(new \DateTime($schedule->start))->format('H:i')}} - {{(new \DateTime($schedule->end))->format('H:i')}}</b>
                        <span class="badge badge-primary">{{$schedule->classroom}}</span><br>
                        <span class="text">{{$schedule->association}}</span><br>
                        <span class="text-muted">{{formatName($schedule->teacher)}}</span>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
@else
    <div>Нет предметов по этому направлению</div>
@endif
