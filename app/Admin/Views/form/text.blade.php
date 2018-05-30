<div class="formRow text">
@if($field['name'] == 'text')
    {{ dd($field) }}
@endif
    {!! Form::label($field['name'], Lang::get($moduleName.'.'.$field['label']), ['class' => isset($field['required']) ? 'required' : '']) !!}
    {!! Form::text($field['name'], $field['value'], ['id' => $field['id'], 'class' => isset($field['class']) ? $field['class'] : '', $field['disabled'] ? 'disabled' : '']) !!}
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
</div>