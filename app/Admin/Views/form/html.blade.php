<div class="formRow html">
<script type="text/javascript">
    $(document).ready(function(){
        tinymce.init({
          selector: '#<?php echo $field['name']; ?>',
          language: 'nl',
          height: 200,
          float:'right',
          plugins: 'table',
          style_formats: [
            { title: 'Bold text', inline: 'strong' },
            { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
            { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
            { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
            { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
          ],
          formats: {
            alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left' },
            aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center' },
            alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right' },
            alignfull: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' },
            bold: { inline: 'span', 'classes': 'bold' },
            italic: { inline: 'span', 'classes': 'italic' },
            underline: { inline: 'span', 'classes': 'underline', exact: true },
            strikethrough: { inline: 'del' },
            customformat: { inline: 'span', styles: { color: '#00ff00', fontSize: '20px' }, attributes: { title: 'My custom format' }, classes: 'example1' },
          }
        });
    });
</script>

    <style type="text/css">
        .mce-tinymce{
            width:31%;
            float:left;
            display:block;
            border: none;
        }
    </style>

    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::textarea($field['name'], $field['value'], ['id' => $field['name'], 'class' => isset($field['class']) ? $field['class'] : '', $field['disabled'] ? 'disabled' : '']) !!}
    @if(isset($field['language']) && $field['language'])
    <div class="lang_attr flag-{{ Session::get('language.default_abbr') }}"></div>
    @endif
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
</div>