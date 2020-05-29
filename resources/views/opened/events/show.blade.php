@extends('layouts.opened')
@section('title'){{$event->name}}@endsection
@section('styles')
    <link href="{{ asset('/css/opened/event.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="event section-padding-both">
        <div class="container">
            <h2>{{$event->name}}</h2>
            @isset($event->img)
                <div class="img-wrapper event-img">
                    <a class="link-primary" target="_blank"
                       href="{{asset('storage/'.$event->img)}}">
                        <img src="{{asset('storage/'.$event->img)}}">
                    </a>
                </div>
            @endisset
            <p class="text-muted">{{$event->organisation}}</p>
            <span class="badge badge-primary">{{(new \DateTime($event->date))->format('d.m.Y')}}</span>
            <p class="text text-pre">{{$event->content}}</p>
        </div>
    </section>
@endsection
