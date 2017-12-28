{!! Form::open(["method" => 'delete', "url" => $data['url']]) !!}
    <div class="title">
        {!! Lang::get($data['urlModule'].'.Delete '.str_singular($data['module'])) !!}
    </div>
    <div class="content">
        <p><b>{{$data['filename']}}</b></p>
        {!! Lang::get('images.Delete this image?') !!}
    </div>
    <div class="buttons">
        <button type="button" id="btnDialogCancel" class="big_button">{!! Lang::get('admin.No') !!}</button>
        <button type="submit" class="big_button">{!! Lang::get('admin.Yes') !!}</button>
    </div>
{!! Form::close() !!}
