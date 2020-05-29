@extends('layouts.opened')
@section('title', 'Главная страница')
@section('styles')
    <link href="{{ asset('/css/opened/index.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/opened/glide.core.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="heading section-padding-both">
        <h1>E-ЗАНЯТОСТЬ</h1>
    </section>
{{--    <section class="carousel">--}}
{{--        <div class="carousel-container">--}}
{{--            <div class="carousel-slide carousel-fade">--}}
{{--                <a href="#"><img src="{{ asset('/images/carousel/1.jpg') }}"></a>--}}
{{--                <div class="carousel-text">--}}
{{--                    <h5>E-Zанятость</h5>--}}
{{--                    <p class="text">Команда студентов Московского Политеха представляет.</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="carousel-slide carousel-fade">--}}
{{--                <a href="#"><img src="{{ asset('/images/carousel/2.jpg') }}"></a>--}}
{{--                <div class="carousel-text">--}}
{{--                    <h5>Школьный портал</h5>--}}
{{--                    <p class="text">Единая информационная система учета и мониторинга обучающихся образовательных организаций города Муравленко.</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <a class="carousel-prev" onclick="plusSlides(-1)"><i class="fa fa-angle-left"></i></a>--}}
{{--            <a class="carousel-next" onclick="plusSlides(1)"><i class="fa fa-angle-right"></i></a>--}}
{{--        </div>--}}
{{--        <div class="carousel-dots">--}}
{{--            <span class="carousel-dot" onclick="currentSlide(1)"></span>--}}
{{--            <span class="carousel-dot" onclick="currentSlide(2)"></span>--}}
{{--        </div>--}}
{{--        <script src="{{ asset('/js/carousel.js') }}"></script>--}}
{{--    </section>--}}
    <section class="carousel">
        <div class="carousel-container">
        <div class="glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <li class="glide__slide carousel-slide carousel-fade">
                        <div>
                        <a href="#"><img src="{{ asset('/images/carousel/1_opt.jpg') }}"></a>
                        <div class="carousel-text">
                            <h5>E-Zанятость</h5>
                            <p class="text">Команда студентов Московского Политеха представляет.</p>
                        </div>
                        </div>
                    </li>
                    <li class="glide__slide carousel-slide carousel-fade">
                        <div>
                        <a href="#"><img src="{{ asset('/images/carousel/2_opt.jpg') }}"></a>
                        <div class="carousel-text">
                            <h5>Школьный портал</h5>
                            <p class="text">Единая информационная система учета и мониторинга обучающихся образовательных организаций города Муравленко.</p>
                        </div>
                        </div>
                    </li>
                    <li class="glide__slide carousel-slide carousel-fade">
                        <div>
                            <a href="#"><img src="{{ asset('/images/carousel/3_opt.jpg') }}"></a>
                            <div class="carousel-text">
                                <h5>Широкая образовательная сеть</h5>
                                <p class="text">С нами каждая образовательная организация города Муравленко.</p>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide carousel-slide carousel-fade">
                        <div>
                            <a href="#"><img src="{{ asset('/images/carousel/4_opt.jpg') }}"></a>
                            <div class="carousel-text">
                                <h5>Органам власти</h5>
                                <p class="text">Управление образовательным процессом региона онлайн. Доступ к актуальной информации – залог эффективных решений!</p>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide carousel-slide carousel-fade">
                        <div>
                            <a href="#"><img src="{{ asset('/images/carousel/5_opt.jpg') }}"></a>
                            <div class="carousel-text">
                                <h5>Педагогам</h5>
                                <p class="text">Инструмент для автоматизации учебного процесса и дистанционного обучения. Модернизируем школу вместе!</p>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide carousel-slide carousel-fade">
                        <div>
                            <a href="#"><img src="{{ asset('/images/carousel/6_opt.jpg') }}"></a>
                            <div class="carousel-text">
                                <h5>Обучающимся</h5>
                                <p class="text">Единое пространство для внеклассной работы и конкурсов. Будь в курсе!</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <a class="glide__arrow glide__arrow--left carousel-prev" data-glide-dir="<"><i class="fa fa-angle-left"></i></a>
                    <a class="glide__arrow glide__arrow--right carousel-next" data-glide-dir=">"><i class="fa fa-angle-right"></i></a>
                </div>
        </div>
        </div>
    </section>
    <section class="organisations section-padding-both">
        <div class="container ">
            <h2>Учреждения</h2>
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @forelse($organisations as $organisation)
                            <li class="glide__slide">
                            <div class="card">
                                <div class="card-img">
                                    <img class="card-img-top"
                                         src="@if($organisation->img){{asset('storage/'.$organisation->img)}}@else{{ asset('/images/noimage.jpg') }}@endif">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/organisations/{{$organisation->id}}" class="link-secondary">
                                            {{$organisation->short_name}}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            </li>
                            @endforeach
                    </ul>
                </div>
                <div class="full-wrapper">
                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left btn btn-outline-primary" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
                        <button class="glide__arrow glide__arrow--right btn btn-outline-primary" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="events section-padding-both">
        <div class="container ">
            <h2>Мероприятия</h2>
            <div class="card-deck">
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
            </div>
            <div class="full-wrapper">
                <a href="/events" class="btn btn-outline-primary">Все мероприятия...</a>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script>
        let sliders = document.querySelectorAll('.glide');
        new Glide(sliders[0], {
            autoplay: 5000,
            gap: 0,
            keyboard: false,
        }).mount();

        new Glide(sliders[1], {
            bound: true,
            perView: 3,
            gap: 0,
            keyboard: false,
            breakpoints: {
                824: {
                    perView: 2,
                },
                568: {
                    perView: 1,
                }
            }
        }).mount()
    </script>
@endsection
