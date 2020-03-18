<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>E-Занятость - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('/css/opened/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/opened/header.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/opened/footer.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div class="wrapper">
        <header class="header-wrapper">
            <div class="container header">
                <div class="header-logo">
                    <img src="{{ asset('/images/logo.png') }}">
                </div>
                <div class="header-bars">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="header-navigation">
                    <nav>
                        <ul>
                            <li><a href="/" class="link-secondary">Главная</a></li>
                            <li><a href="" class="link-secondary">Учреждения</a></li>
                            <li><a href="" class="link-secondary">Мероприятия</a></li>
                            <li><a href="" class="link-secondary">Контакты</a></li>
                            <li><a href="{{ route('login') }}" class="btn btn-outline-primary"><i class="fas fa-user"></i> Личный кабинет</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="footer">
            <section class="container footer-upper">
                <div class="footer-nav">
                    <h5>Навигация</h5>
                    <a href="/" class="link-primary">Главная</a>
                    <a href="" class="link-primary">Учреждения</a>
                    <a href="" class="link-primary">Мероприятия</a>
                    <a href="" class="link-primary">Контакты</a>
                    <a href="/login" class="link-primary">Личный кабинет</a>
                </div>
                <div class="footer-info">
                    <h5>Правовая информация</h5>
                    <a href="" class="link-primary">Лицензионное соглашение</a>
                    <a href="" class="link-primary">Политика обработки персональных данных</a>
                    <a href="" class="link-primary">Авторские права</a>
                </div>
                <div class="footer-gototop">
                    <a href="javascript:void(0);" class="link-primary">Наверх <i class="fas fa-angle-up"></i></a>
                </div>
            </section>
            <section class="container footer-lower">
                <p>Свирин Сергей. Московский Политехнический Университет.</p>
            </section>
        </footer>
    </div>
</body>
</html>
