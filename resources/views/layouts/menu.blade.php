
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-edit"></i><span>Пользователи</span></a>
</li>

<li class="{{ Request::is('phones*') ? 'active' : '' }}">
    <a href="{{ route('phones.index') }}"><i class="fa fa-edit"></i><span>Мошенники</span></a>
</li>


<li class="{{ Request::is('comments*') ? 'active' : '' }}">
    <a href="{{ route('comments.index') }}"><i class="fa fa-edit"></i><span>Комментарии</span></a>
</li>

<li class="{{ Request::is('cards*') ? 'active' : '' }}">
    <a href="{{ route('cards.index') }}"><i class="fa fa-edit"></i><span>Карты</span></a>
</li>
