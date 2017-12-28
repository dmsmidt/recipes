{{-- THUMB --}}
<div class="thumb thumb_{{$row}}">
    <div class="image_holder"><img src="/uploads/{{$thumb['template']}}/thumb/{{$thumb['filename']}}" alt="{{$thumb['filename']}}">
        <div class="details">
            <div class="size">{{$thumb['filesize']}}</div>
            <div class="filename">{{$thumb['filename']}}</div>
            <?php
                $thumb['language'] = true; //TODO: dynamisch maken!
            ?>
            {!! Form::hidden($field."[id][".$row."]", $thumb['id']) !!}
            {!! Form::hidden($field."[field][".$row."]", $field) !!}
            {!! Form::hidden($field."[filename][".$row."]", $thumb['filename']) !!}
            {!! Form::hidden($field."[template][".$row."]", $thumb['template']) !!}
            {!! Form::hidden($field."[filesize][".$row."]", $thumb['filesize']) !!}
        </div>
    </div>
    <div class="imageRow text">
        {!! Form::label($field, Lang::get('images.Alt text')) !!}
        @if(isset($thumb->alt))
            @foreach($thumb->alt->all() as $alt)
                @foreach(Session::get('language.active') as $language)
                    @if($alt['language_id'] == $language['id'])
                        {!! Form::hidden($field."[alt_".$language['abbr']."][".$row."]", $alt['alt'], ['class' => 'language']) !!}
                        @if(Session::get('language.default_id') == $language['id'])
                            {!! Form::text($field."[alt][".$row."]", $alt['alt'], ['id' => $field."[alt][".$row."]", 'class' => 'image_input']) !!}
                        @endif
                    @endif
                @endforeach
            @endforeach
        @else
            {!! Form::text($field."[alt][".$row."]", $thumb['alt'], ['id' => $field."[alt][".$row."]", 'class' => 'image_input']) !!}
            @foreach($thumb['languages'] as $language)
                {!! Form::hidden($field."[alt_".$language."][".$row."]", $thumb['alt_'.$language], ['class' => 'language']) !!}
            @endforeach
        @endif
        @if(isset($thumb['language']) && $thumb['language'])
            <div class="lang_attr flag-{{ Session::get('language.default_abbr') }}"></div>
        @endif
    </div>
    <div class="buttons">
        <button type="button" class="btnCrop row_btn" data-field="{{$field}}"
                                                       data-id="{{$thumb['id']}}"
                                                       data-url="/admin/images/{{$thumb['id']}}"
                                                       data-filename="{{$thumb['filename']}}"
                                                       data-module="{{$moduleName}}"
                                                       data-template="{{$thumb['template']}}"><div class="icon-crop"></div></button>
        <button type="button" class="btnImageDelete row_btn" data-field="{{$field}}"
                                                             data-id="{{$thumb['id']}}"
                                                             data-url="/admin/images/{{$thumb['id']}}"
                                                             data-filename="{{$thumb['filename']}}"
                                                             data-module="{{$moduleName}}"
                                                             data-dialog="image_delete"><div class="icon-delete"></div></button>
    </div>
</div>






