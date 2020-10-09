@extends('main.layouts.app')

@section('title', config()->get('app.name'))

@section('content')
    <div>
        <div class="bg-red text-center pt-4 pb-4">
            <img class="rounded mx-auto d-block" src="{{ asset('images/StopFraud_960x432.png') }}" alt="">
            <h2 class="text-white">Всеукраинская база данных информации о мошенниках</h2>
            <a class="btn btn-danger btn-lg align-center" href="{{route('fraud.create')}}">Сообщить о мошеннике</a> <br>
        </div>
    </div>

    <div class="container">
        <div class="row pt-4 pb-4">
            <div class="col-lg-4 text-center">
                <a href="{{route('advices')}}"><img src="{{ asset('images/StopFraudFinger0_600-300x300.png') }}" alt=""></a>
                <h3>Ответь жулику правильно</h3>
                <p>
                    Что нельзя делать при звонке с неизвестного номера? Как вести себя при телефонном разговоре с
                    потенциальным жуликом?
                </p>
                <p>
                    <strong>
                        Ознакомьтесь с основными правилами и советами поведения при телефонном разговоре с неизвестным
                        абонентом!
                    </strong>
                </p>
                <a class="btn btn-danger btn-lg" href="{{route('advices')}}">Читать советы</a></div>
            <div class="col-lg-4 text-center">
                <a href="{{route('fraud.index')}}"><img src="{{ asset('images/StopFraudFinger1_600-300x300.png') }}" alt=""></a>
                <h3>Пробей мошенника по базе</h3>
                <p>
                    Собираетесь совершить покупку через Интернет? Потеряли что-либо и теперь вам звонят с предложениями
                    вернуть утрату за деньги?
                </p>
                <p>
                    <strong> Проверьте базу данных FraudHunt - не станьте жертвой мошенников!</strong>
                </p>
                <a class="btn btn-danger btn-lg" href="{{route('fraud.index')}}">Проверить в базе</a></div>
            <div class="col-lg-4 text-center">
                <a href="{{route('fraud.create')}}"><img src="{{ asset('images/StopFraudFinger3_600-300x300.png') }}" alt=""></a>
                <h3>Сообщи об аферисте</h3>
                <p>
                    Чуть не попались на удочку мошенникам? Столкнулись с кибер-аферистами, которые пытались развести вас
                    на
                    деньги?
                </p>
                <p>
                    <strong>
                        Сделайте доброе дело, сообщите об этом друзьям и знакомым! Помогите им не быть обманутыми
                        аферистами!
                    </strong>
                </p>
                <a class="btn btn-danger btn-lg" href="{{route('fraud.create')}}">Сообщить о жулике</a></div>
        </div>
    </div>

    <div class="pt-4 pb-4 bg-red text-white">
        <div class="container">
            <div class="row">
                <h1 class="text-left">
                    Мобильное приложение - FraudHunt
                </h1>
            </div>
            <div class="row">
                <div class="col-lg-4 text-center">
                    <img src="{{asset('images/AppFraudHunt_screen_news-300x300.png')}}" alt=""></div>
                <div class="col-lg-8 align-left">
                    <h3>
                        FraudHunt - это мобильное приложение, которое даёт возможность добавлять в адресную книгу Вашего
                        телефона номера мошенников, жуликов и прочих телефонных аферистов, собранных в всеукраинской
                        базе
                        данных "FraudHunt".
                    </h3>
                    <p>
                        Не дай мошенникам шанса, загрузи FraudHunt !
                    </p>
                    <p>
                        <a href="https://play.google.com/store/apps/details?id=com.klevrit.fraudhunt" target="_blank">
                            <img src="{{asset('images/googleplay_get.png')}}" alt=""> </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
