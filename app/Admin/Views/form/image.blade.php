{{-- dd($field) --}}
<div class="formRow {{$field['name']}} image">
    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    <div class="input">
        <div class="thumbs">
        {{-- Multiple images field --}}

        @if(is_object($field['value']))
            @foreach($field['value'] as $key => $thumb)
                @include('form.thumb',["field" => $field['name'], "row" => $key, "thumb" => $thumb])
            @endforeach
        @else
            @if(isset($field['value']) && !empty($field['value']))
                @include('form.thumb',["field" => $field['name'], "row" => 0, "thumb" => $field])
            @endif
        @endif
        </div>

        <div class="dropzone {{$field['name']}} @if( isset($field['max_reached']) && $field['max_reached'] ) max_reached @endif"
             data-field="{{$field['name']}}"
             data-image_template="{{$field['image_template']}}"
             data-max_files="@if(isset($field['max_files'])){{ $field['max_files'] }}@else{{1}}@endif"
             data-maxsize="@if(isset($field['maxsize'])){{ $field['maxsize'] }}@else{{5}}@endif"
             @if(isset($field['max_files']) && $field['max_files'] > 1)
                 @if( isset($field['max_reached']) && $field['max_reached'])
                    data-message="{{ \Lang::get('images.Maximum number of images reached, you can not upload any more.') }}"
                 @else
                    data-message="{{ \Lang::get('images.Click or drop images here to upload') }}"
                 @endif
             @else
                data-message="{{ \Lang::get('images.Click or drop an image here to upload') }}"
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
    var img_cnt = $('.thumbs > div').length;
    $('.dropzone.{{$field['name']}}').dropzone({
        url: "/admin/upload/images",
        maxFilesize: data.maxsize,
        maxFiles: data.max_files - $('.'+data.field+' .thumbs .thumb').length,
        addRemoveLinks: false,
        dictDefaultMessage: data.message,
        dictMaxFilesExceeded: 'images.Maximum number of images reached, you can not upload any more.',
        //previewTemplate: $('#preview-template').html(),
        params: {
            image_template: data.image_template,
            max_files: data.max_files,
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
            $('.image.{{$field['name']}} .input .thumbs').append(response.thumb);
        },
        queuecomplete: function(file){
            $('.image.{{$field['name']}} .input .dropzone .dz-preview').remove();
            $('.image.{{$field['name']}} .input .dropzone .dz-message').show();
            if(img_cnt >= data.max_files){
                $('.image.{{$field['name']}} .input .dropzone .dz-message').html('<span>{{\Lang::get('images.Maximum number of images reached, you can not upload any more.')}}</span>');
            }else{
                //console.log('Number images okay!');
            }
            //console.log('data.maxFiles: ',data.max_files );
        },
        init: function(){
            this.on('error',function(dz, data){
                console.log('error data: ',data);
            });
        }
    });

});

</script>
