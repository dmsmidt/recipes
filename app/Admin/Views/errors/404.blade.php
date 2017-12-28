
<!DOCTYPE html>
<html lang="{{ \Session::get('user.language') }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Admin - 404 error</title>
    <meta name="viewport" content="width=device-width">
    {{--<link rel="icon" href="/cms/img/favicon.ico" type="image/x-icon" />--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/normalize.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/main.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/vendor/jquery-ui/jquery-ui.css">
    <script type="text/javascript" src="/cms/js/modernizr-3.5.0.min.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-3.2.1.min.js"></script>
</head>

<body>
<!-- header -->
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

<!--container-->
<div class="container">

    <section class="mainmenu"></section>
    <main>
        <div class="top-bar">
            {{-- TITLE --}}
            <h1>Error 404</h1>
        </div>
        <div class="center">
            <h1>{{ Lang::get("admin.Page not found") }}</h1>
            <p>
                {{ Lang::get("admin.The requested page doesn't exist.") }}<br>
                <a href="javascript: window.history.back();">{{ Lang::get('Admin.Back') }}</a>
            </p>
        </div>
    </main>

</div>
<!--/container-->

<!-- message dialog -->
<div id="dialog"></div>
<!-- /message dialog -->

<!-- crop dialog -->
<div id="crop"></div>
<!-- /crop dialog -->

<!-- page blockers -->
<div id="dialogblocker">&nbsp;</div>
<div id="pageblocker">
    <div id="progress_cursor"></div>
</div>
<!-- /page blockers -->

<script type="text/javascript" src="/cms/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="/cms/js/admin.js"></script>
</body>
</html>
