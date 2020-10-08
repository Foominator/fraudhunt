




<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-edit"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('phones*') ? 'active' : '' }}">
    <a href="{{ route('phones.index') }}"><i class="fa fa-edit"></i><span>Phones</span></a>
</li>

