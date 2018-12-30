<div class="formRow html">

    <style type="text/css">
        .mce-tinymce{
            float:left;
            display:block;
            border: none;
        }
    </style>

    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::textarea($field['name'], $field['value'], ['id' => $field['name'], 'class' => isset($field['class']) ? $field['class'] : '', $field['disabled'] ? 'disabled' : '']) !!}
    <script type="text/javascript">
        $(document).ready(function(){
            tinymce.init({
              selector: '#{{ $field['name'] }}',
              language: 'nl',
              height: '200px',
              width: '31%',
              plugins: 'table'
            });
        });
    </script>
    @if(isset($field['language']) && $field['language'])
    <div class="lang_attr flag-{{ Session::get('language.default_abbr') }}"></div>
    @endif
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
    
</div>