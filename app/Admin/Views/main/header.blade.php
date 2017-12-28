<header>
    <div class="logo">
        <div>
            CMS {{ \Config::get('admin.version') }}
        </div>
    </div>
    <span class="domain">{{ substr(URL::to('/'),7)}}</span>
    <div class="user">

        <div id="user">
            <a class="logout" href="/admin/logout" title="{{ Lang::get('admin.Logout') }}"><div class="fa fa-power-off"></div></a>
            <div class="username">{{ Lang::get('admin.Welcome') }} <a href="/admin/users/{{ Session::get('user.id') }}/edit"> {{ Session::get('user.name') }} </a></div>
        </div>

    </div>
</header>