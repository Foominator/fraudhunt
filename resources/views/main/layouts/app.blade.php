<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="pl-5 navbar-brand" href="/"><img src="{{asset('images/FraudHunt_Logo_160x55_5.png')}}" width="25" alt=""></a>
    <a class="navbar-brand" href="#">FRAUDHUNT</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2 pr-5">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item pl-4">
                <a class="nav-link" href="#">Контакты</a> <!-- contacts -->
            </li>
            <li class="nav-item pl-4">
                <a class="nav-link" href="#">Правила</a> <!-- rules -->
            </li>
            <li class="nav-item pl-4">
                <a class="nav-link" href="#">Мошенники</a> <!-- frauds -->
            </li>
            <li class="nav-item pl-4">
                <a class="nav-link" href="#">Добавить мошенника</a> <!-- add fraud -->
            </li>
            <li class="nav-item pl-4">
                <a class="nav-link" href="#">Полезные советы</a> <!-- advices -->
            </li>

            @auth
                <li class="nav-item pl-4">
                    <a href="{{ url('/logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Выйти <i class="fa fa-sign-out"></i>
                    </a>
                </li>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <li class="nav-item pl-4">
                    <a class="nav-link" href="{{ route('register') }}">Регистрация</a> <!-- registration -->
                </li>
                <li class="nav-item pl-4">
                    <a class="nav-link" href="{{ route('login') }}">
                        Вход <i class="fa fa-plus"></i>
                    </a> <!-- login -->
                </li>
            @endif
        </ul>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="navbar  bg-dark">
    <div class="text-center pb-1 pt-2">
        <p class="text-secondary">
            Размещая или используя информацию в базе данных "FraudHunt" вы подтверждаете своё согласие с <a
                href="/rules">Правилами использования сервиса</a>. Все права защищены. Любое копирование, публикация,
            перепечатка материалов сайта разрешается при условии наличия прямой индексируемой гиперссылки на
            "Всеукраинская база данных информации о мошенниках «Fraud Hunt»".
        </p>
    </div>
</footer>
<!-- Footer -->
</body>
</html>
