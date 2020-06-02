@extends('layouts.opened')
@section('title', 'Учреждения')
@section('content')
    <section class="organisations section-padding-both">
        <div class="container">
            <h2>Учреждения</h2>
            <div class="card-deck">
                @forelse($organisations as $organisation)
                    <div class="card">
                        <div class="card-img">
                            <img class="card-img-top"
                                 src="@if($organisation->img){{asset('storage/'.$organisation->img)}}@else{{ asset('/images/noimage.png') }}@endif">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/organisations/{{$organisation->id}}" class="link-secondary">
                                    {{$organisation->short_name}}
                                </a>
                            </h5>
                        </div>
                    </div>
                @empty
                    <div>Пока нет ни одного учреждения</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
