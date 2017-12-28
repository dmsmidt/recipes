<div class="formRow checkbox">
    <label class="@if(isset($field['required'])) required @endif">{{ Lang::get($moduleName.'.'.$field['label']) }}</label>
    {!! Form::checkbox($field['name'], '1', $field['value'] == '1' ? true : false, ['id' => $field['id'], 'class' => isset($field['class']) ? $field['class'] : '', $field['disabled'] ? 'disabled' : '']) !!}
    <label class="checkbox_style" for="{{ $field['id'] }}"><span></span></label>
    @if(isset($field['language']) && $field['language'])
    <div class="lang_attr flag-{{ Session::get('language.default_abbr') }}"></div>
    @endif
    <span class="error_msg">{!! $errors->first($field['error']) !!}</span>
</div>