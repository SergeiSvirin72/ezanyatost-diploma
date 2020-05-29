<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>E-Занятость - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('/css/closed/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/closed/index.css') }}" rel="stylesheet">
    @yield('styles')
<!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(64456888, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/64456888" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-node">
            <ul class="sidebar-list">
                <li><a href="/home"><i class="fas fa-user"></i> Личный кабинет</a></li>
                <li><a href="/"><i class="fas fa-globe-europe"></i> На сайт</a></li>
            </ul>
        </div>
        <div class="sidebar-node">
            @if(in_array(\Auth::user()->role_id, [1, 2]))
                <p class="text-muted sidebar-header">Отчеты</p>
            @endif
            <ul class="sidebar-list">
                @if(in_array(\Auth::user()->role_id, [1, 2]))
                    <li><a href="/report/class"><i class="fas fa-chart-bar"></i><span>Охват дополнительным образованием по классам</span></a></li>
                    <li><a href="/report/status"><i class="fas fa-columns"></i><span>Охват дополнительным образованием по статусам</span></a></li>
                    @if(\Auth::user()->role_id == 1 || (\Auth::user()->role_id == 2 && \App\Organisation::where('organisations.director_id', \Auth::id())->value('is_school')))
                        <li><a href="/report/student"><i class="fas fa-layer-group"></i><span>Охват дополнительным образованием по обучающимся</span></a></li>
                        <li><a href="/report/attendance"><i class="fas fa-user-friends"></i><span>Посещаемость по школьникам</span></a></li>
                    @endif
                    <li><a href="/report/course"><i class="fas fa-chart-pie"></i><span>Перечень направлений внеурочной деятельности</span></a></li>

                @endif
                @if(in_array(\Auth::user()->role_id, [1, 2, 5]))
                    <li><a href="/report/event"><i class="fas fa-calendar-day"></i><span>Традиционные мероприятия</span></a></li>
                @endif
                @if(in_array(\Auth::user()->role_id, [5]))
                    <li><a href="/report/homework/student"><i class="fas fa-book"></i><span>Домашнее задание</span></a></li>
                    <li><a href="/report/involvement"><i class="fas fa-shapes"></i><span>Расписание</span></a></li>
                    <li><a href="/report/visit"><i class="fas fa-user-friends"></i><span>Посещения</span></a></li>
                @endif
            </ul>
        </div>
        <div class="sidebar-node">
            @if(in_array(\Auth::user()->role_id, [1, 2]))
                <p class="text-muted sidebar-header">Администрирование</p>
            @endif
            <ul class="sidebar-list">
                @if(in_array(\Auth::user()->role_id, [1]))
                    <li><a href="/admin/users"><i class="fas fa-users"></i><span>Пользователи</span></a></li>
                    <li><a href="/admin/organisations"><i class="fas fa-building"></i><span>Учреждения</span></a></li>
                @endif
                @if(in_array(\Auth::user()->role_id, [1, 2]))
                    <li><a href="/admin/associations"><i class="fas fa-bell"></i><span>Объединения</span></a></li>
                    <li><a href="/admin/teachers"><i class="fas fa-chalkboard-teacher"></i><span>Преподаватели</span></a></li>
                    <li><a href="/admin/schedules"><i class="fas fa-calendar"></i><span>Расписания</span></a></li>
                    @if(\Auth::user()->role_id == 1 || (\Auth::user()->role_id == 2 && \App\Organisation::where('organisations.director_id', \Auth::id())->value('is_school')))
                        <li><a href="/admin/students"><i class="fas fa-user-graduate"></i><span>Обучающиеся</span></a></li>
                        <li><a href="/admin/statuses"><i class="fas fa-link"></i><span>Статусы</span></a></li>
                        <li><a href="/admin/involvements"><i class="fas fa-shapes"></i><span>Вовлеченность</span></a></li>
                    @endif
                    <li><a href="/admin/events"><i class="fas fa-calendar-day"></i><span>Мероприятия</span></a></li>
                @endif
                @if(in_array(\Auth::user()->role_id, [1, 2, 3]))
                    <li><a href="/admin/homeworks"><i class="fas fa-book"></i><span>Домашние задания</span></a></li>
                    <li><a href="/admin/attendances"><i class="fas fa-user-friends"></i><span>Посещаемость</span></a></li>
                @endif
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
<script src="{{ asset('js/showSidebar.js') }}"></script>
</html>
