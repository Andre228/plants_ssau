<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}" />

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

    </head>
    <body class="app-body">

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top header-container">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <i class="fab fa-pagelines" style="font-size: 40px; color: darkseagreen;"></i>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-container" id="navbarResponsive">

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item active">
                            <a href="#" class="nav-link nav-link-hover">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-hover">Новости</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-hover">Экспонаты</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-hover">Раздел</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-hover">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-link-hover">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-login-link"><i class="far fa-user" style="font-size: 18px;"></i></a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>



        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>














    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</html>
