<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE') }}">
<head>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>CMS - login</title>
    <meta name="viewport" content="width=device-width">
    {{--<link rel="icon" href="/cms/img/favicon.ico" type="image/x-icon" />--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/normalize.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/main.css">
    <link media="all" type="text/css" rel="stylesheet" href="/cms/css/fontawesome-all.css">
    <script type="text/javascript" src="/cms/js/modernizr-3.5.0.min.js"></script>
    <script type="text/javascript" src="/cms/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <!--container-->
    <div class="container">
        @yield("content")
    </div>
</body>
</html>
