
<div class="formRow email">
    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::email($field['name'], $field['value'], ['id' => $field['id'], 'class' => isset($field['class']) ? $field['class'] : '', $field['disabled'] ? 'disabled' : '']) !!}
    @if(isset($field['language']) && $field['language'])
    <div class="lang_attr flag-{{ Session::get('language.default_abbr') }}"></div>
    @endif
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
</div>