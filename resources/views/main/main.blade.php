@extends('main.layouts.app')

@section('title', config()->get('app.name'))

@section('content')
    <div>
        <div class="bg-red text-center pt-4 pb-4">
            <img class="rounded mx-auto d-block" src="{{ asset('images/StopFraud_960x432.png') }}" alt="">
            <h2 class="text-white">{{__('messages.main.header')}}</h2>
            <a class="btn btn-danger btn-lg align-center"
               href="{{(new App\Services\RouteBuilder)->route('fraud.create')}}">{{__('messages.main.button')}}</a> <br>
        </div>
    </div>

    <div class="container">
        <div class="row pt-4 pb-4">
            <div class="col-lg-4 text-center">
                <a href="{{(new App\Services\RouteBuilder)->route('advices')}}"><img src="{{ asset('images/StopFraudFinger0_600-300x300.png') }}" alt=""></a>
                <h3>{{__('messages.main.button1_header')}}</h3>
                <p>
                    {{__('messages.main.button1_text')}}
                </p>
                <p>
                    <strong>{{__('messages.main.button1_description')}}</strong>
                </p>
                <a class="btn btn-danger btn-lg" href="{{(new App\Services\RouteBuilder)->route('advices')}}">{{__('messages.main.button1')}}</a></div>
            <div class="col-lg-4 text-center">
                <a href="{{(new App\Services\RouteBuilder)->route('fraud.index')}}"><img src="{{ asset('images/StopFraudFinger1_600-300x300.png') }}"
                                                        alt=""></a>
                <h3>{{__('messages.main.button2_header')}}</h3>
                <p>
                    {{__('messages.main.button2_text')}}

                </p>
                <p>
                    <strong>{{__('messages.main.button2_description')}}</strong>
                </p>
                <a class="btn btn-danger btn-lg" href="{{(new App\Services\RouteBuilder)->route('fraud.index')}}">{{__('messages.main.button2')}}</a>
            </div>
            <div class="col-lg-4 text-center">
                <a href="{{(new App\Services\RouteBuilder)->route('fraud.create')}}"><img src="{{ asset('images/StopFraudFinger3_600-300x300.png') }}"
                                                         alt=""></a>
                <h3>{{__('messages.main.button3_header')}}</h3>
                <p>
                    {{__('messages.main.button3_text')}}
                </p>
                <p>
                    <strong>{{__('messages.main.button3_description')}}</strong>
                </p>
                <a class="btn btn-danger btn-lg" href="{{(new App\Services\RouteBuilder)->route('fraud.create')}}">{{__('messages.main.button3')}}</a>
            </div>
        </div>
    </div>

    {{--Мобильное приложение--}}
    @if(false)
        <div class="pt-4 pb-4 bg-red text-white">
            <div class="container">
                <div class="row">
                    <h1 class="text-left">
                        {{__('messages.main.app_header')}}
                    </h1>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <img src="{{asset('images/AppFraudHunt_screen_news-300x300.png')}}" alt=""></div>
                    <div class="col-lg-8 align-left">
                        <h3>
                            {{__('messages.main.app_text')}}
                        </h3>
                        <p>
                            {{__('messages.main.app_advice')}}
                        </p>
                        <p>
                            <a href="https://play.google.com/store/apps/details?id=com.klevrit.fraudhunt"
                               target="_blank">
                                <img src="{{asset('images/googleplay_get.png')}}" alt=""> </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
