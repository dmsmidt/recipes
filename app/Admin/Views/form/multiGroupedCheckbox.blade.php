<div class="formRow multigroupedcheckbox">

    <label
        for="{{ $field['name'] }}"
        @if(isset($field['required']) && $field['required'])class="required"@endif>
        {{ Lang::get($moduleName.'.'.$field['label']) }}
    </label>
</div>
{{--dd($field['options'])--}}
@foreach($field['options'] as $group => $option)
<div class="parentRow">

    <button type="button" class="btnGroupExpand" data-group="{{ $group }}"><div class="far fa-plus-square"></div></button>

    <div class="parentTitle">{{ $group }}</div>

</div>
    @foreach($option as $val)
    <div class="multiCheckboxGroup group" data-group="{{ $group }}">
        <div class="formRow checkbox">
            <label style="margin-left:18px;" for="{{ $val['name'] }}">
                {{ $val['label'] }}
            </label>
            <input type="checkbox"
                   name="{{ $val['name'] }}"
                   id="{{ $val['name'] }}"
                   value="{{ $val['id'] }}"
                   class="{{ $val['class'] }}"
                   {{ $val['value'] }} >

            <label for="{{ $val['name'] }}"><span></span></label>
            <span class="error_msg"></span>
        </div>
    </div>
    @endforeach
@endforeach