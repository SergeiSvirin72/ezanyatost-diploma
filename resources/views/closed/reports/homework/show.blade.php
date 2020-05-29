@extends('layouts.closed')
@section('title') Домашнее задание @endsection
@section('content')
    <h3>{{$homework->association}}</h3>
    <p class="text-muted">{{$homework->organisation}}</p>
    <span class="badge badge-primary">{{(new \DateTime($homework->date))->format('d.m.Y')}}</span>
    <section class="section-padding-both">
        <div class="lead">
            <div>
                <h4>Задание:</h4>
                <p class="text">{{$homework->value}}</p>
            </div>
        </div>
    </section>
    @if(count($materials))
        <div class="lead">
            <h4>Дополнительные материалы:</h4>
            <ul class="list">
                @foreach($materials as $material)
                    <li><a class="link-primary"
                           target="_blank"
                           href="{{asset('storage/'.$material->link)}}">{{$material->link}}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
