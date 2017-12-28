<tr>
    <td style="padding-left:8px;"><button class="btn table_btn" type="button" data-rowname="fieldrow_{{$row}}"><div class="icon-tree-expand"></div></button></td>

    {{-- NAME COLUMN --}}
    <td><input type="text" name="field[{{ $row }}][name]" id="field_name_{{ $row }}" value="{{ $name }}"></td>

    {{-- TYPE COLUMN --}}
    <td>@include('recipes.recipes_type',['row' => $row, 'name' => $name, 'field' => $field])</td>

    {{-- INPUT COLUMN --}}
    <td>@include('recipes.recipes_input',['row' => $row, 'name' => $name, 'field' => $field])</td>

    {{-- INPUT OPTIONS COLUMN --}}
    <td>@include('recipes.recipes_inputoptions',['row' => $row, 'name' => $name, 'field' => $field])</td>

    {{-- RULES COLUMN --}}
    <td>@include('recipes.recipes_rules',['row' => $row, 'name' => $name, 'field' => $field])</td>

    {{-- FIELD OPTIONS COLUMN --}}
    <td>@include('recipes.recipes_fieldoptions',['row' => $row, 'name' => $name, 'field' => $field])</td>

    {{-- ROW OPTIONS --}}
    <td>
        <button title="Delete field" type="button" data-row="{{ $row }}" class="btnDeleteFieldRow" style="margin: 6px 0 0 5px; ">
            <div class="icon-delete"></div>
        </button>
    </td>
</tr>
