@extends('layouts.closed')
@section('title'){{$event->name}}@endsection
@section('content')
    <h2>{{$event->name}}</h2>
    <div>
        @isset($event->img)
            <div class="img-wrapper">
                <a class="link-primary" target="_blank"
                   href="{{asset('storage/'.$event->img)}}">
                    <img src="{{asset('storage/'.$event->img)}}">
                </a>
            </div>
        @endisset
            <p class="text-muted">{{$event->organisation}}</p>
            <span class="badge badge-primary">{{(new \DateTime($event->date))->format('d.m.Y')}}</span>
            <p class="text">{{$event->content}}</p>
    </div>
@endsection
