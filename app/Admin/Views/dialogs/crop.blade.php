{!! Form::open(["method" => 'PUT', "url" => '/admin/images/'.$data['id']]) !!}
    <div class="title">
        {!! Lang::get('images.Crop image') !!} <b>{{$data['filename']}}</b>
    </div>
    <div class="content">
        @foreach($data['crop_formats'] as $format)
        <div class="image_preview" id="{{$format['name']}}">
            <img style="{{$data['preview_size']['width']}}; height: {{$data['preview_size']['height']}};" src="/uploads/{{$data['template']}}/preview/{{$data['filename']}}">
        </div>
        @endforeach
        <div class="buttons">
            <button type="button" id="btnSaveCrop" class="btn big_button"><div class="icon-save"></div><span>Opslaan</span></button>
            <button type="button" id="btnCropCancel" class="big_button"><div class="icon-cancel"></div><span>Annuleer</span></button>
        </div>

    </div>
{!! Form::close() !!}
