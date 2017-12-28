<fieldset>
<div class="formRow multiple">
    {!! Form::label($field['name'],$field['label']) !!}
    @if($field['add'])
        <button type="button" class="btnMultipleAdd big_button" data-field="{!! $field['name'] !!}"><div class="icon-add"></div><span>{!! \Lang::get('cms.New') !!}</span></button>
    @endif


     <div class="add_form {!! $field['name'] !!}">
        @foreach($field['add_form']['formfields'] as $addfield)
            {!! $addfield['field'] !!}
        @endforeach
        <label>&nbsp;</label>
        <button type="button" class="btnMultipleAddSave big_button" data-field="{!! $field['name'] !!}"><div class="icon-save"></div><span>{!! \Lang::get('cms.Save') !!}</span></button>
        <button type="button" class="btnMultipleAddCancel big_button" data-field="{!! $field['name'] !!}"><div class="icon-cancel"></div><span>{!! \Lang::get('cms.Cancel') !!}</span></button>
    </div>


    <ul class="overview" id="{!! $field['name'] !!}_overview">
        <li class="headers sort_disabled">
            <div class="col_sort"></div>
            @foreach($field['headers'] as $head)
                <div class="col_{!! $head['type'] !!}">{!! \Lang::get($field['name'].'.'.$head['text']) !!}</div>
            @endforeach
            <div class="col_options">{!! \Lang::get($field['name'].'.Options') !!}</div>
        </li>

        @if(count($field['rows']))
             @foreach($field['rows'] as $row)
                {!! $row !!}
            @endforeach
        @endif
    </ul>

</div>
</fieldset>