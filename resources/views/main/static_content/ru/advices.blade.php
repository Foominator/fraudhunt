@extends('main.layouts.app')

@section('title', 'Полезные советы')

@section('content')
    <div class="container pt-4">
        <h1>Полезные советы</h1>
        <div class="row">
            <div class="col-lg-12">
                <h2><b>Что делать если друг просит помощи через соцсеть?</b></h2>
            </div>
            <div class="col-lg-11 offset-lg-1">
                <h3>В последнее время участились случаи нового вида мошенничества через социальные сети – клонирование
                    странички (аккаунта).</h3>
                <h4>Схема мошенничества «Соцклон»</h4>
                <p>Мошенники заходят к вам на страничку, скачивают все ваши данные: персональную информацию, фотографии,
                    видео, сообщения со стены и тд.</p>
                <p>Затем создают точную копию (клон) вашей странички.</p>
                <p>Потом заходят к вашим друзьям и просят выручить до завтра: кинуть какую-то сумму на карточку или
                    телефон. Особенно актуальна такая схема мошенничества по отношению активным пользователям социальных
                    сетей, к тем людям, у кого большое количество друзей и подписчиков.</p>
                <span class="text-danger">
                <h4>Что должно настораживать в поведении «Вашего друга»?</h4>
                <ol>
                    <li>Повторная просьба добавить в друзья его или его друга.</li>
                    <li>Просьба, под разными предлогами, что-либо сделать: дать ему Ваши контакты (адрес эл. почты, телефон), пополнить его телефон, банковскую карточку и т.д.</li>
                    <li>Сообщение, о находке вашей потерянной вещи или компрометирующей вас информации.</li>
                </ol>
            </span>
                <span class="text-success">
                <h4>Ваши действия, если друг просит что-либо через соцсеть</h4>
                <ol>
                    <li>Быть внимательными.</li>
                    <li>Если это вам не друг, а так… виртуальный знакомый из соцсети, то лучше проигнорировать срочные просьбы.</li>
                    <li>Если вы знаете этого человека в реальной жизни – созвонитесь с ним. Нет возможности позвонить, посмотрите, что делается на его страничке в других соцсетях. Анализируйте, думайте.</li>
                    <li>Если к просьбе, сообщении «Вашего друга» прикреплены подозрительные файлы (архивы, файлы с не известными вам расширениями) – не открывайте их. Если прилагаются фото, попробуйте найти их дубли с помощью <a
                            href="http://www.google.com.ua/intl/ru/insidesearch/features/images/searchbyimage.html">сервиса Google</a>.</li>
                </ol>
            </span>
                <div class="card border-info">
                    <div class="card-header bg-info">
                        Запомните!
                    </div>
                    <div class="card-body">
                        Вся информация, опубликованная вами в сети Интернет, может бать использована против вас.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2><b>Что делать, если Вам позвонили и сообщили, что найдено Вашу вещь?</b></h2>
            </div>
            <div class="col-lg-11 offset-lg-1">
                <h3>Если Вы потеряли какую-то вещь и Вам позвонили сообщить о находке, необходимо знать основные правила
                    при телефонном разговоре с абонентом:</h3>
                <span class="text-success">
                <h4>Что Вам необходимо сделать:</h4>
                <ol>
                    <li>Спросить откуда узнали о Вашей потере.</li>
                    <li>Убедиться, что это действительно Ваша вещь, поинтересовавшись о деталях и месте находки: спросите, к примеру, серийный номер документа (не спрашивайте фамилию или дату вашего рождения, ведь эти сведения легко узнать используя соц.сети), цвет обложки и др.</li>
                    <li>Если Вы думаете, что это все-таки Ваша вещь, договориться о месте встречи и условиях её возврата.</li>
                </ol>
            </span>
                <span class="text-danger">
                <h4>Чего не надо делать:</h4>
                <ol>
                    <li>Не соглашайтесь на встречу в малолюдных местах.</li>
                    <li>Не передавайте вознаграждение через третье лицо.</li>
                    <li>Не перезванивайте на номер звонившего вам абонента или любой другой номер, который вам может быть предложено.</li>
                    <li>Не отвечайте на вопросы о вашей потере.</li>
                    <li>Не делайте каких-либо действий по передаче вознаграждения, пока не получите собственную утраченную вещь.</li>
                    <li>Если утеряны документы на авто или ключи - ни в коем случае не выезжайте на встречу на данном транспортном средстве, так как таким образом мошенник может узнать дополнительные сведения о вашей потере.</li>
                </ol>
            </span>
                <div class="card border-info">
                    <div class="card-header bg-info">
                        Запомните!
                    </div>
                    <div class="card-body">
                        Человек, который действительно стремится вернуть потерю владельцу, <strong>никогда не будет
                            поднимать вопрос о вознаграждении!</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2><b>Что делать, если Вы получили SMS с предложением перейти на более выгодный тариф?</b></h2>
            </div>
            <div class="col-lg-11 offset-lg-1">
                <h3>Безобидное, на первый взгляд, SMS с предложением, перейти на более выгодный тариф, может стать
                    причиной обнуления вашего мобильного счёта.Именно с помощью такой рассылки мошенникам зачастую
                    удаётся улучшить своё благосостояние.</h3>
                <h4>Как работает схема.</h4>
                <p>Абонент, не обращая внимания на то, что отправителем сообщений является не их оператор (очень часто
                    это тяжело выяснить даже намеренно), откликается на предложение: "Отправь SMS на короткий номер,
                    чтобы перейти на более выгодный тариф!</p>
                <p>В следствие отправки сообщения на указанный короткий номер или даже простого нажатия кнопки "Ok"
                    желая просто закрыть сообщение, вероятней всего жертва, то есть Вы, получите SMS подобного рода :
                    "Поздравляем, теперь все звонки в сети оператора – бесплатны!".</p>

                <p>Вы радуетесь, но не долго ибо вскоре реальный оператор сообщит Вам о том, что на счету меньше 1
                    гривны, или что-то вроде этого, и Вам не обходимо пополнить счёт.</p>
                <p>Итог Вашей невнимательности – "0" на счету и глубокое чувство обиды.</p>
                <p>Всё дело в том, что практически все операторы предлагают платный сервис – короткий номер, который и
                    используют мошенники.</p>
                <p>Узнать стоимость услуги отправки SMS или звонка на короткий номер можно на фосайтах операторов:<a
                        href="http://www.kyivstar.ua/f/1/mm/entertainment/partner_services/sms_services_rus.xls"> для
                        абонентов KyivStar</a> ( файл таблиц *.xls), <a
                        href="http://www.mts.ua/ru/support/services/8-kak-uznat-stoimot-zvonka-ili-sms-na-specialnyj-nomer-korotkij-nomer-informacionnye-sluzhby-kompanij-0-800/">для
                        абонентов MTS</a> ( файл таблиц *.xls)</p>

                <div class="card border-info mb-4">
                    <div class="card-header bg-info">
                        Рекомендации:
                    </div>
                    <div class="card-body padding-bottom-0">
                        <ol>
                            <li>Не совершайте действий, которые не планировали.</li>
                            <li>Если Вам предложение действительно показалось выгодным, перепроверьте его на офсайте
                                вашего оператора мобильной связи.
                            </li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection