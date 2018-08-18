<div class="row fieldrow_{{$row}}">
    @if(isset($field['type_options']) && in_array('unsigned',$field['type_options']))
        <input type="checkbox" value="1" name="field[{{ $row }}][unsigned]" id="field_unsigned_{{ $row }}" @if(isset($field['unsigned']) && $field['unsigned'])checked @endif><label style="vertical-align: sub">Unsigned</label>
    @endif
    @if(isset($field['type_options']) && in_array('unique',$field['type_options']))
        <input type="checkbox" value="1" name="field[{{ $row }}][unique]" id="field_unique_{{ $row }}" @if(isset($field['unique']) && $field['unique'])checked @endif><label style="vertical-align: sub">Unique</label>
    @endif
    @if(isset($field['type_options']) && in_array('nullable',$field['type_options']))
        <input type="checkbox" value="1" name="field[{{ $row }}][nullable]" id="field_nullable_{{ $row }}" @if(isset($field['nullable']) && $field['nullable'])checked @endif><label style="vertical-align: sub">Nullable</label>
    @endif
</div>
@if(isset($field['type_options']) && in_array('default',$field['type_options']))
    <div class="row fieldrow_{{$row}}"><label class="text">Default</label><input type="text" name="field[{{ $row }}][default]" id="field_default_{{ $row }}" value="@if(isset($field['default'])){{ $field['default'] }}@endif"></div>
@endif
@if(isset($field['type_options']) && in_array('length',$field['type_options']))
    <div class="row fieldrow_{{$row}}"><label class="text">Length</label><input type="text" name="field[{{ $row }}][length]" id="field_length_{{ $row }}" value="@if(isset($field['length'])){{ $field['length'] }}@endif"></div>
@endif
@if(isset($field['type_options']) && in_array('decimals',$field['type_options']))
    <div class="row fieldrow_{{$row}}"><label class="text">Decimals</label><input type="text" name="field[{{ $row }}][decimals]" id="field_decimals_{{ $row }}" value="@if(isset($field['decimals'])){{ $field['decimals'] }}@endif"></div>
@endif
@if(isset($field['type_options']) && in_array('options',$field['type_options']))
    <div class="row fieldrow_{{$row}}"><label class="text">Options</label><input type="text" name="field[{{ $row }}][typeoptions]" id="field_typeoptions_{{ $row }}" value="@if(isset($field['typeoptions'])){{ $field['typeoptions'] }}@endif"></div>
@endif
@if(isset($field['type_options']) && in_array('relation',$field['type_options']))
    <div class="row fieldrow_{{$row}}"><label class="text">Relation</label><input type="text" name="field[{{ $row }}][relation]" id="field_relation_{{ $row }}" value="@if(isset($field['relation'])){{ $field['relation'] }}@endif"></div>
@endif