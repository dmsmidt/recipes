<div class="formRow {{$field['name']}} image">
    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::hidden('_field', $field['name'])!!}
    <div class="input">
        <div class="thumbs">
        {{-- Multiple images field --}}

        @if(is_array($field['value']))
            @foreach($field['value'] as $key => $thumb)
                @include('form.thumb',["field" => $field['name'], "row" => $key, "thumb" => $thumb])
            @endforeach
        @else
                {{-- dd($field) --}}

        {{-- Single image

            @include('form.thumb',["field" => $field['name'], "row" => 0, "thumb" => $field])--}}
        @endif
        <?php
                $thumbs = Session::get('input')[$field['name']];
                $active_languages = Session::get('language.active');
                $languages = [];
                foreach($active_languages as $key => $lang){
                    $languages[] = $lang['abbr'];
                }
                if(is_array($thumbs)){
                    $input = [];
                    foreach($thumbs as $row => $thumb){
                        $input[$row]['field'] = $field['name'];
                        $input[$row]['row'] = $row;
                        $input[$row]['id'] = $thumb['id'];
                        $input[$row]['filename'] = $thumb['filename'];
                        $input[$row]['filesize'] = $thumb['filesize'];
                        $input[$row]['image_template'] = $field['image_template'];
                        $input[$row]['alt'] = $thumb['alt'];
                        $input[$row]['languages'] = $languages;
                        $input[$row]['languages'] = $languages;
                        if(isset($languages)){
                            foreach($languages as $language){
                                $input[$row]['alt_'.$language] = $thumb['alt_'.$language];
                            }
                        }
                    }
                }
            ?>
            {{--@if(isset($input))
                @foreach($input as $key => $thumb)
                    @include('form.thumb',["field" => $field['name'], "row" => $key, "thumb" => $thumb])
                @endforeach
            @endif--}}

        </div>
        <div class="dropzone {{$field['name']}}"
             data-field="{{$field['name']}}"
             data-image_template="{{$field['image_template']}}"
             data-maxfiles="@if(isset($field['maxfiles'])){{ $field['maxfiles'] }}@else{{1}}@endif"
             data-maxsize="@if(isset($field['maxsize'])){{ $field['maxsize'] }}@else{{5}}@endif"
             @if(isset($field['maxfiles']) && $field['maxfiles'] > 1)
                data-message="{{ \Lang::get('Images.Click or drop images here to upload') }}"
             @else
                data-message="{{ \Lang::get('Images.Click or drop an image here to upload') }}"
             @endif
             >
        </div>
        <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
    </div>
</div>

<script type="text/javascript" src="/cms/js/dropzone.js"></script>

<script>

Dropzone.autoDiscover = false;

$(document).ready(function(){
    /**
    * DROPZONE IMAGE UPLOAD
    */
    var data = $('.dropzone.{{$field['name']}}').data();
    console.log(data);
    var img_cnt = $('.thumbs > div').length;
    $('.dropzone.{{$field['name']}}').dropzone({
        url: "/admin/upload/images",
        maxFilesize: data.maxsize,
        maxFiles: data.maxfiles,
        addRemoveLinks: false,
        dictDefaultMessage: data.message,
        //previewTemplate: $('#preview-template').html(),
        params: {
            image_template: data.image_template,
            maxfiles: data.maxfiles,
            maxsize: data.maxsize,
            filename: 'temp',
            field: data.field
        },
        accept: function(file, done) {
                    console.log('accept');
                    //add further logic for accepting images
                    $('.image.{{$field['name']}} .input .dropzone .dz-message').hide();
                    done();
        },
        sending: function(file, xhr, formData){
            formData.append('_token', $('meta[name="_token"]').attr('content'));
            formData.append('template', $('#image_template').val());
            formData.append('row',img_cnt);
            img_cnt++;
        },
        success: function(file, response){
            addThumb(response.thumb);
        },
        queuecomplete: function(file){
            $('.image.{{$field['name']}} .input .dropzone .dz-preview').remove();
            $('.image.{{$field['name']}} .input .dropzone .dz-message').show();
        },
        init: function(){
            this.on('error',function(dz, data){
                console.log(data);
            });
        }
    });

    /**
     * ADDING THUMB AT IMAGE INPUT FIELD
     */
    addThumb = function(data){
        $('.image.{{$field['name']}} .input .thumbs').append(data);
    }

});

</script>
