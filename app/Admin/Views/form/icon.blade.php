<div class="formRow icon">
    <label
        for="{{ $field['name'] }}"
        @if(isset($field['required']) && $field['required'])class="required"@endif>
        {{ Lang::get($moduleName.'.'.$field['label']) }}
    </label>
    <div data-current="{!! $field['value'] !!}" class="btnIconSelect {!! $field['value'] !!}"></div>
    <input type="hidden"
           name="{{ $field['name'] }}"
           id="{{ $field['id'] }}"
           value="@if(old($field['name'])) {{ old($field['name']) }} @else {{ $field['value'] }} @endif"
           class="@if(isset($field['class'])){{ $field['class'] }}@endif">
    @if(isset($field['btn_id']))
    {!! $field['btn_id'] !!}
    @endif
</div>