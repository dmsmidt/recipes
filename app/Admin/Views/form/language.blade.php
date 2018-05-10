
<div class="formRow language">
    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::text($field['name'], $field['value'], ['id' => $field['id'], 'class' => isset($field['class']) ? $field['class'] : '', $field['disabled'] ? 'disabled' : '']) !!}
    <div class="lang_attr flag-{{ Session::get('language.default_abbr') }}"></div>
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
</div>