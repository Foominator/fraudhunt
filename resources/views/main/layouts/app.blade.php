<!DOCTYPE html>
@php $currentRouteName = request()->route()->getName(); @endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')

    <link rel="icon" type="image/png" href="{{asset('images/FraudHunt_Logo_160x55_5.png')}}"/>
</head>
<body>

<div id="app">
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="pl-5 navbar-brand" href="{{route('main')}}"><img
                    src="{{asset('images/FraudHunt_Logo_160x55_5.png')}}"
                    width="25" alt=""></a>
            <a class="navbar-brand" href="{{route('main')}}">FRAUDHUNT</a>

            @if (auth()->check() && auth()->user()->isAdmin())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item pl-4">
                        <a class="nav-link" href="{{route('home')}}">AdminPanel</a>
                    </li>
                </ul>
            @endif
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale())}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if('ua' ==app()->getLocale())
                            <a class="dropdown-item" href="{{route('set-locale', ['locale' => 'ru'])}}">RU</a>
                        @else
                            <a class="dropdown-item" href="{{route('set-locale', ['locale' => 'ua'])}}">UA</a>
                        @endif
                    </div>
                </li>
            </ul>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2 pr-5">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item pl-4 @if('rules' === $currentRouteName) active @endif">
                        <a class="nav-link" href="{{route('rules')}}">{{__('menu.rules')}}</a> <!-- rules -->
                    </li>
                    <li class="nav-item pl-4 @if('fraud.index' === $currentRouteName) active @endif">
                        <a class="nav-link" href="{{route('fraud.index')}}">{{__('menu.frauds')}}</a> <!-- frauds -->
                    </li>
                    <li class="nav-item pl-4 @if('fraud.create' === $currentRouteName) active @endif">
                        <a class="nav-link" href="{{route('fraud.create')}}">{{__('menu.add_fraud')}}</a> <!-- add_fraud -->
                    </li>
                    <li class="nav-item pl-4 @if('advices' === $currentRouteName) active @endif">
                        <a class="nav-link" href="{{route('advices')}}">{{__('menu.advices')}}</a> <!-- advices -->
                    </li>

                    @auth
                        <li class="nav-item pl-4">
                            <a href="{{ url('/logout') }}" class="nav-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{__('menu.logout')}} <i class="fa fa-door-open"></i>
                            </a>
                        </li>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item pl-4">
                            <a class="nav-link" href="{{ route('register') }}">{{__('menu.registration')}}</a> <!-- registration -->
                        </li>
                        <li class="nav-item pl-4">
                            <a class="nav-link" href="{{ route('login') }}">
                                {{__('menu.login')}} <i class="fa fa-door-closed"></i>
                            </a> <!-- login -->
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        @yield('content')

    </div>
    <!-- Footer -->
    <footer class="navbar bg-dark">
        <div class="text-center pb-1 pt-2">
            <p class="text-secondary">
                Размещая или используя информацию в базе данных "FraudHunt" вы подтверждаете своё согласие с <a
                    href="{{route('rules')}}">Правилами использования сервиса</a>. Все права защищены. Любое
                копирование,
                публикация,
                перепечатка материалов сайта разрешается при условии наличия прямой индексируемой гиперссылки на
                "Всеукраинская база данных информации о мошенниках «Fraud Hunt»".
            </p>
        </div>
    </footer>
    <!-- Footer -->

</div>
<script src="{{asset('js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
