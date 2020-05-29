@extends('layouts.opened')
@section('title', 'Учреждения')
@section('content')
    <section class="events section-padding-both">
        <div class="container">
            <h2>Мероприятия</h2>
            <form name="fetch">
                @csrf
                <input type="hidden" name="page" value="1">
                <div class="form-group">
                    Выберите учреждение:
                    <select name="organisation"
                            class="form-control form-control-block dynamic dynamic-start">
                        @if ($all)
                            <option value="">Все</option>
                        @endif
                        @foreach($organisations as $organisation)
                            <option value="{{$organisation->id}}" {{ (old('organisation_id') == $organisation->id ? "selected":"") }}>
                                {{$organisation->short_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="card-deck">

            </div>
        </div>
    </section>
    <script src="/js/fetchEvents.js"></script>
@endsection
