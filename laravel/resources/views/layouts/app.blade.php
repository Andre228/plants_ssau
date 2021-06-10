<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Виртуальный гербарий Самарского университета</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-content.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>


</head>
<body class="app-body">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top header-container">
            <div class="container-fluid">
                <a href="{{ route('museum.welcome') }}" class="navbar-brand">
                    <i class="fab fa-pagelines" style="font-size: 40px; color: darkseagreen;"></i>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-container" id="navbarResponsive">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">


                        <li class="nav-item active">
                            <a href="{{ route('museum.welcome') }}" class="nav-link nav-link-hover">Главная</a>
                        </li>
                        {{--<li class="nav-item">--}}
                            {{--<a href="#" class="nav-link nav-link-hover">Новости</a>--}}
                        {{--</li>--}}
                        <li class="nav-item">
                            <a href="{{ route('museum.posts.view') }}" class="nav-link nav-link-hover">Экспонаты</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('museum.category') }}" class="nav-link nav-link-hover">Раздел</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('museum.contacts') }}" class="nav-link nav-link-hover">Контакты</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt" style="font-size: 18px; margin-right: 8px;"></i>{{ __('Войти') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus" style="font-size: 18px; margin-right: 8px;"></i>{{ __('Регистрация') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <login-title-component :user="{{ Auth::user() }}"></login-title-component><span class="caret"></span>
                                </a>


                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fas fa-user" style="font-size: 18px; margin-right: 8px;"></i>{{ __('Профиль') }}
                                    </a>
                                    @if( Auth::user()->role == 'admin' )
                                        <a class="dropdown-item" href="{{ route('museum.admin_dashboard.index') }}">
                                            <i class="fas fa-clipboard-list" style="font-size: 18px; margin-right: 8px;"></i>{{ __('Управление') }}
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt" style="font-size: 18px; margin-right: 8px;"></i>{{ __('Выйти') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if (Auth::user())
            <global-search-component></global-search-component>
        @endif

        <page-scroll-component></page-scroll-component>

        <div class="container main-content">
            <main class="py-4">
                @yield('content')
            </main>
        </div>

        <footer class="text-muted py-5 container footer-container mb-2" style="background-color: white">
            <div class="container">
                <p class="float-end mb-1">
                    <a href="#">Наверх</a>
                </p>
                <h2 style="border-bottom: 2px solid #0d6efd">
                    Контакты
                </h2>
                <div class="row justify-content-lg-around col-lg-12">
                    <div class="mb-1 col-lg-8">Адрес: 443028, Самара, Московское шоссе, 28, 22 корпус, 614 кабинет.</div>
                    <div class="mb-1 col-lg-4"><i class="fas fa-phone"></i><span class="ml-2">Тел. 8 (846) 334-54-43</span></div>
                </div>

                <div class="mt-2">
                    <h2 style="border-bottom: 2px solid #0d6efd">
                        Кураторы гербария:
                    </h2>

                    <div class="mb-1 col-lg-12">
                        <span style="border-bottom: 1px solid #f88b80">Богданова Я. А. (мохоборазные),</span>
                        <br>
                        <span style="border-bottom: 1px solid #f8d997">Корчиков Е. С. (лишайники),</span>
                        <br>
                        <span style="border-bottom: 1px solid #88e792">Корчикова Т. А., Кузовенко О. А.,  Макарова Ю. В., Плаксина Т. И.,Шаронова И. В. (сосудистые растения).</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>