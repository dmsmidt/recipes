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
    var files = [];
    var error_files = [];
    var error_file_names = [];
    var messages = [];
    var msg_too_big = "{{ \Lang::get('images.is too large.') }}";
    var msg_passed_max = "{{ \Lang::get('images.passed maximum number of images.') }}";

    $('.dropzone.{{$field['name']}}').dropzone({
        url: "/admin/upload/images",
        maxFilesize: data.maxsize,
        maxFiles: data.max_files - $('.'+data.field+' .thumbs .thumb').length,
        addRemoveLinks: false,
        dictDefaultMessage: data.message,
        dictMaxFilesExceeded: 'images.Maximum number of images reached, you can not upload any more.',
        acceptedFiles: 'image/*',
        //previewTemplate: $('#preview-template').html(),
        params: {
            image_template: data.image_template,
            max_files: data.max_files,
            maxsize: data.maxsize,
            filename: 'temp',
            field: data.field
        },
        accept: function(file, done) {
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
            files = this.files;
            $('.image.{{$field['name']}} .input .dropzone .dz-preview').remove();
            $('.image.{{$field['name']}} .input .dropzone .dz-message').show();
            //hide dropzone if max images has been reached
            if(this.files.length >= data.max_files){
                $('.image.{{$field['name']}} .input .dropzone').hide();
            }
            //show alert dialog with errors
            if(error_file_names.length){
                var messages = [];
                $.each(error_file_names, function(k,v){
                    if(error_files[k]){
                        if( (error_files[k].size * 1024 **-2) > data.maxsize){
                            messages.push(
                                {
                                'type' : 'alert',
                                'text' : error_files[k].name+' '+msg_too_big,
                                }
                            );
                        }
                        console.log('amount: ',files.length,data.max_files);
                        if( (files.length + $('.thumbs .thumb').length)  > data.max_files){
                            messages.push(
                                {
                                'type' : 'alert',
                                'text' : error_files[k].name+' '+msg_passed_max,
                                }
                            );
                        }
                    }
                });
               ajaxRequest(
                {
                    method: 'dialog',
                    params: {
                        'module'   : '{{ $moduleName }}',
                        'dialog'   : 'attention',
                        'messages' : messages,
                        'icon'         : null,
                        'page_refresh' : 0
                    },
                    callback: 'openDialog'
                });
            }
            error_files = [];
            error_file_names = [];
            messages = [];
        },
        init: function(){
            //TODO show alert dialog for too big file on upload request
            this.on('error',function(dz, data){
                $.each(this.files, function(k, v){
                    if(v.status === 'error'){
                        if($.inArray(v.name, error_file_names) < 0){
                            error_files.push(v);
                            error_file_names.push(v.name);
                        }
                    }
                });
            });
        }
    });

});

</script>
