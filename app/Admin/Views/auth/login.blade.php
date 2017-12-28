@extends("auth")
@section("content")

    <div id="login" class="clearfix">

        <div class="logo-info clearfix">
            <div>CMS {{ Config::get('admin.version') }}</div>
        </div>
        <form role="form" action="{{ url('/admin/login') }}" method="POST">
        <div class="login_form clearfix">
            <h2>{{ Lang::get('admin.CMS login') }}</h2><br>
            {{ csrf_field() }}
            <p style="color:#F6763F;margin-left: 32px; margin-top:5px;">
                {!! $errors->first('email') !!}
                {!! $errors->first('password') !!}
            </p>
            <label for="email">{{ Lang::get('admin.Username') }}: </label><input name="email" type="text" id="email" value="{{ old('email') }}" /><br>

            <label for="password">{{ Lang::get('admin.Password') }}: </label><input name="password" type="password" id="password" />

            <button style="margin-left:153px; margin-top:4px;" class="form_button" type="submit"><i class="fa fa-unlock"></i>{{ Lang::get('admin.Login') }}</button>
            <br /><div id="error_msg" style="text-align:center; padding:5px; color:#FF0000;"></div>
        </div>
        </form>

    </div>

@stop