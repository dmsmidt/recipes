
<div class="formRow select">
    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::select($field['name'], $field['options'], $field['value'], ['class' => isset($field['class']) ? $field['class'] : '']) !!}
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
</div>