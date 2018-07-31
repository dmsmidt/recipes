
{!! Form::open(["method" => 'PUT', "url" => '/admin/images/'.$data['id']]) !!}
    <div class="title">
        {!! Lang::get('images.Crop image') !!} <b>{{$data['filename']}}</b>
    </div>
    <div class="content">
        @foreach($data['image_formats'] as $format)
        <div class="image_preview" id="{{$format['name']}}">
            <img style="{{$format->width}}; height: {{$format->height}};" src="/storage/uploads/{{$format->image_template}}/preview/{{$data['filename']}}">
        </div>
        @endforeach
        <div class="buttons">
            <button type="button" id="btnSaveCrop" class="btn big_button"><div class="fas fa-save"></div><span>Opslaan</span></button>
            <button type="button" id="btnCropCancel" class="big_button"><div class="fas fa-ban"></div><span>Annuleer</span></button>
        </div>
    </div>
{!! Form::close() !!}
