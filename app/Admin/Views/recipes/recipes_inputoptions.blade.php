
    <select class="field_inputoptions" name="field[{{ $row }}][inputoptions]" id="field_inputoptions_{{ $row }}"
            @if(!isset($field['input']) || ($field['input'] != 'select' && $field['input'] != 'radio' && $field['input'] != 'multiGroupedCheckbox')) disabled @endif
            data-row="{{ $row }}">
        <option value="" @if(!isset($field['options'])) selected @endif>---</option>
        <option value="db_table" @if(isset($field['options']) && isset($field['options']['table'])) selected @endif>db table</option>
        <option value="array" @if(isset($field['options']) && !isset($field['options']['table'])) selected @endif>array</option>
    </select>

    <div class="row fieldrow_{{ $row }} inputoptionrow_{{ $row }}">
        <div class="table table_input_{{ $row }}" @if(isset($field['options']['table'])) style="display:block;" @endif>
            {{-- TABLE INPUT --}}
            <label class="text">Table</label>
            <input type="text" name="field[{{ $row }}][inputoptions_table]" id="inputoptions_table_{{ $row }}" value="@if(isset($field['options']['table'])){{ $field['options']['table'] }}@endif">

            {{-- LABEL FOR FIELDS INPUT --}}
            <label class="text" style="width:90%">Fields for:</label>

            {{-- INPUT TABLE FIELD FOR OPTION LABEL/TEXT --}}
            <label class="text">Label</label>
            <input type="text" name="field[{{ $row }}][inputoptions_label]" id="inputoptions_label_{{ $row }}" value="@if(isset($field['options']['text'])){{ $field['options']['text'] }}@endif">

            {{-- INPUT TABLE FIELD FOR OPTION VALUE --}}
            <label class="text">Value</label>
            <input type="text" name="field[{{ $row }}][inputoptions_value]" id="inputoptions_value_{{ $row }}" value="@if(isset($field['options']['value'])){{ $field['options']['value'] }}@endif">
            <hr>

            {{-- INPUT TABLE FIELD FOR GROUP BY --}}
            <label class="text">Group by</label>
            <input type="text" name="field[{{ $row }}][inputoptions_group_by]" id="inputoptions_group_by_{{ $row }}" value="@if(isset($field['options']['group_by'])){{ $field['options']['group_by'] }}@endif">
            <hr>

            {{-- INPUT TABLE FIELD FOR FILTERING | relation: <tablename.fieldname = value> local table <fieldname = value>  --}}
            <label class="text">Filter by</label>
            <input type="text" name="field[{{ $row }}][inputoptions_filter_by]" id="inputoptions_filter_by_{{ $row }}" value="@if(isset($field['options']['filter_by'])){{ $field['options']['filter_by'] }}@endif">
        </div>

        <div class="array array_input_{{ $row }} inputoptionrow_{{ $row }}" @if(isset($field['options']) && !isset($field['options']['table'])) style="display:block;" @endif>
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><label style="float:left; margin:2px 5px 0 26%;">options</label>
                            <button title="Add option row" type="button" class="row_btn btnAddArrayOption" data-row="{{ $row }}" style="margin: 2px 2px; float:left;">
                                <div class="icon-add"></div>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>label</td>
                        <td>value</td>
                    </tr>
                    @if(isset($field['options']) && !empty($field['options']) && !isset($field['options']['table']))
                        @foreach($field['options'] as $key=>$val)
                        <tr>
                            <td><input type="text" name="field[{{ $row }}][inputoptionslabel_array][{{ $key }}]" id="inputoptionslabel_array_{{ $row }}_{{ $key }}" value="@if(isset($val['text'])){{ $val['text'] }}@endif"></td>
                            <td><input type="text" name="field[{{ $row }}][inputoptionsvalue_array][{{ $key }}]" id="inputoptionsvalue_array_{{ $row }}_{{ $key }}" value="@if(isset($val['value'])){{ $val['value'] }}@endif"></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>




