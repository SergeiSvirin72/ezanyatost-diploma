@foreach($events as $event)
    <div class="card">
        <div class="card-img">
            <img class="card-img-top"
                 src="@if($event->img){{asset('storage/'.$event->img)}}@else{{ asset('/images/noimage.jpg') }}@endif">
        </div>
        <div class="card-body">
            <h5><a href="/events/{{$event->id}}" class="link-secondary">{{$event->name}}</a></h5>
            <p class="text-muted">{{$event->organisation}}</p>
            <span class="badge badge-primary">{{(new \DateTime($event->date))->format('d.m.Y')}}</span>
            <p class="card-text">{{$event->content}}</p>
        </div>
    </div>
@endforeach
<div style="flex-basis: 100%;">{{ $events->links() }}</div>

