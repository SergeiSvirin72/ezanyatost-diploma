<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>E-Занятость - @yield('title')</title>
    <link href="{{ asset('/css/closed/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/closed/index.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-node">
            <ul class="sidebar-list">
                <li><a href="/home"><i class="fas fa-user"></i> Профиль</a></li>
                <li><a href="/"><i class="fas fa-globe-europe"></i> На сайт</a></li>
            </ul>
        </div>
        <div class="sidebar-node">
            <p class="text-muted sidebar-header">Отчеты</p>
            <ul class="sidebar-list">
            </ul>
        </div>
        <div class="sidebar-node">
            <p class="text-muted sidebar-header">Администрирование</p>
            <ul class="sidebar-list">
                <li><a href="/admin/organisations"><i class="fas fa-chart-bar"></i> Учреждения</a></li>
                <li><a href="/admin/associations"><i class="fas fa-chart-bar"></i> Объединения</a></li>
            </ul>
        </div>
        <div class="sidebar-node">
            <p class="text-muted sidebar-header">Связи</p>
            <ul class="sidebar-list">
                <li><a href="/admin/association-organisation"><i class="fas fa-chart-bar"></i> Объединение - Учреждение</a></li>
            </ul>
        </div>
    </aside>
    <div class="wrapper">
        <header>
            <nav class="navbar">
                <div class="navbar-bars">
                    <a href="javascript:void(0);"><i class="fas fa-bars"></i></a>
                </div>
                <div class="navbar-right">
                    <div class="navbar-user">
                        <img src="img/">
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <div class="navbar-logout">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Выйти</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <section class="section-padding-both">
                <div class="container">
                    @yield('content')
                </div>
            </section>
        </main>
    </div>
</body>
</html>
