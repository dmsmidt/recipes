{{-- <pre>print_r($data,true)</pre> --}}
{!! Form::open(["method" => 'PUT', "url" => '/admin/images/'.$data['id']]) !!}
    <div class="title">
        {!! Lang::get('images.Crop image') !!} <b>{{$data['filename']}}</b>
    </div>
    <div class="content">
        <div class="image_formats">
            @foreach($data['image_formats'] as $format)
            <button type="button" class="big_button btnImageFormat @if($loop->first) active @endif" data-image_format="{{ $format['name'] }}">{{ $format['name'] }}</button>
            @endforeach
        </div>
        @foreach($data['image_formats'] as $row => $format)
        <div class="image_preview @if($loop->first) active @endif" id="{{ $format['name'] }}">
            {!! Form::hidden($format['name'].'_x', $format['x'], ['id' => $format['name'].'_x', 'class' => '']) !!}
            {!! Form::hidden($format['name'].'_y', $format['y'], ['id' => $format['name'].'_y', 'class' => '']) !!}
            {!! Form::hidden($format['name'].'_width', $format['width'], ['id' => $format['name'].'_width', 'class' => '']) !!}
            {!! Form::hidden($format['name'].'_height', $format['height'], ['id' => $format['name'].'_height', 'class' => '']) !!}
            {!! Form::hidden($format['name'].'_constraint', $format['constraint'], ['id' => $format['name'].'_constraint', 'class' => '']) !!}
            <img src="/storage/uploads/{{ $data['image_template'] }}/preview/{{$data['filename']}}" class="{{ $format['name'] }}"
             data-image_format="{{ $format['name'] }}" data-x="{{ $format['x'] }}" data-y="{{ $format['y'] }}" data-width="{{ $format['width'] }}" data-height="{{ $format['height'] }}" data-constraint="{{ $format['constraint'] }}">
            <div class="values">
                <ul>
                    <li><label>X1:</label><span class="{{ $format['name'] }}_x1"></span></li>
                    <li><label>Y1:</label><span class="{{ $format['name'] }}_y1"></span></li>
                    <li><label>X2:</label><span class="{{ $format['name'] }}_x2"></span></li>
                    <li><label>Y2:</label><span class="{{ $format['name'] }}_y2"></span></li>
                    <li><label>{{ Lang::get('Width') }}:</label><span class="{{ $format['name'] }}_width"></span></li>
                    <li><label>{{ Lang::get('Height') }}:</label><span class="{{ $format['name'] }}_height"></span></li>
                </ul>
            </div> 
        </div>
        @endforeach
        {!! Form::hidden('id', $data['id'], ['id' => 'id', 'class' => '']) !!}
        <div class="buttons">
            <button type="button" id="btnSaveCrop" class="big_button"><div class="fas fa-save"></div><span>Opslaan</span></button>
            <button type="button" id="btnCropCancel" class="big_button"><div class="fas fa-ban"></div><span>Annuleer</span></button>
        </div>
    </div>
{!! Form::close() !!}
