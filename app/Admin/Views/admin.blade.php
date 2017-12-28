<!DOCTYPE html>
<html lang="{{ \Session::get('user.language') }}">
<head>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>CMS</title>
    <meta name="viewport" content="width=device-width">
    {{--<link rel="icon" href="/cms/img/favicon.ico" type="image/x-icon" />--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/normalize.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/main.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/vendor/jquery-ui/jquery-ui.css">
    @if(isset($plugins['css']))
        @foreach($plugins['css'] as $css)
    <link media="all" type="text/css" rel="stylesheet" href="{!! $css !!}">
        @endforeach
    @endif
    <script type="text/javascript" src="/cms/js/modernizr-3.5.0.min.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-3.2.1.min.js"></script>


</head>

<body>
<!-- header -->
@include('main.header')

<!--container-->
<div class="container">

    @include('main.menu')
    <main>
        @include('main.topbar')
        <div class="center">
        {!! $center !!}
        </div>
        @include('main.bottombar')
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
<script type="text/javascript" src="/cms/js/dialog.js"></script>
<script type="text/javascript" src="/cms/js/crop.js"></script>
@if(isset($plugins['javascript']))
    @foreach($plugins['javascript'] as $javascript)
        <script type="text/javascript" src="{!! $javascript !!}"></script>
    @endforeach
@endif
</body>
</html>
