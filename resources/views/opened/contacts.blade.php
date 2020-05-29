@extends('layouts.opened')
@section('title', 'Контакты')
@section('styles')
    <link href="{{ asset('/css/opened/contacts.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="contacts section-padding-both">
        <div class="container">
            <h2>Контакты</h2>
            <div class="contacts-upper">
                <div class="contacts-column">
                    <p class="text">
                        Оставьте свое сообщение в этой форме, мы получим его на e-mail и обязательно ответим!
                    </p>
                    <form action="/contacts" method="post">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{$errors->first()}}
                            </div>
                        @endif
                        <div class="form-group">
                            <input class="form-control" type="text" name="name" placeholder="Имя" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" placeholder="Электронная почта" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="thee" placeholder="Тема" value="{{ old('thee') }}">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" placeholder="Сообщение">{{ old('message') }}</textarea>
                        </div>
                        <input type="submit" class="btn btn-outline-primary" value="Отправить">
                    </form>
                </div>
                <div class="contacts-column">
                    <p class="text">
                        <b>Расположение:</b><br>
                        ЯНАО г. Муравленко ул. Ленина, 65,<br>
                        Муравленко, Тюменская область, 629601
                    </p><br>
                    <p class="text">
                        <b>Управление образования:</b> + 7 (985) 415-59-75<br>
                        <b>Заказчик:</b> <a href="javascript:void(0);" class="link-primary">Snychevam@mail.ru</a><br>
                        <b>Менеджер:</b> <a href="javascript:void(0);" class="link-primary">Zaikogalina59@mail.ru</a><br>
                        <b>Разработчик:</b> <a href="javascript:void(0);" class="link-primary">Darkraver2012@gmail.com</a><br>
                    </p>
                </div>
            </div>
            <div class="map-handler">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A9d5347b8ba692ab9cb3c013b2cd5ede20cfa04ad76765a5e9d9c3adb5671e63d&amp;width=100%25&amp;height=520&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
        </div>
    </section>
@endsection
