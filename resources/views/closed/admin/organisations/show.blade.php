@extends('layouts.closed')
@section('title'){{$organisation->short_name}}@endsection
@section('content')
    <h2>{{$organisation->short_name}}</h2>
    <h3>Об учреждении</h3>
    <div>
        @isset($organisation->img)
            <div class="img-wrapper">
                <a class="link-primary" target="_blank"
                   href="{{asset('storage/'.$organisation->img)}}">
                    <img src="{{asset('storage/'.$organisation->img)}}">
                </a>
            </div>
        @endisset
        <div class="lead">
            <p>
                <b>Полное наименование:</b>
                <span>{{$organisation->full_name}}</span>
            </p>
            <p>
                <b>Краткое наименование:</b>
                <span>{{$organisation->short_name}}</span>
            </p>
            <p>
                <b>ФИО руководителя:</b>
                <span>{{$organisation->director}}</span>
            </p>
            <p>
                <b>Часы  приема:</b>
                <span>{{$organisation->reception}}</span>
            </p>
            <p>
                <b>Юридический адрес:</b>
                <span>{{$organisation->legal_address}}</span>
            </p>
            <p>
                <b>Фактический адрес:</b>
                <span>{{$organisation->actual_address}}</span>
            </p>
            <p>
                <b>Телефон:</b>
                <a class="link-primary"
                   href="tel:{{$organisation->phone}}">{{$organisation->phone}}</a>
            </p>
            @isset($organisation->fax)
                <p>
                    <b>Факс:</b>
                    <span>{{$organisation->fax}}</span>
                </p>
            @endisset
            <p>
                <b>Электронная почта:</b>
                <a class="link-primary"
                   href="mailto:{{$organisation->email}}">{{$organisation->email}}</a>
            </p>
            <p>
                <b>Веб-сайт:</b>
                <a class="link-primary"
                   target="_blank"
                   href="http://{{$organisation->website}}">{{$organisation->website}}</a>
            </p>
        </div>
    </div>
@endsection
