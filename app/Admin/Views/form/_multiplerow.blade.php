
    <li class="item_row {!! $row['modulename'] !!}_row"
        data_row="{!! $row['modulename'].'_'.$row['id'] !!}"
        data-id="{{ $row['id'] }}">
        @if($row['sortable'])
            <div class="summary_col_{!! $row['id'] !!} col_sort">
                <button type="button" class="sort_button row_btn"><div class="icon-"></div></button>
            </div>
        @else
            <div class="summary_col_{!! $row['id'] !!} col_sort">&nbsp;</div>
        @endif

        @foreach($row['cols'] as $key => $col)
            <div class="col_{!! $col['field']['type'] !!} {!! $row['modulename'].'_'.$row['id'].'_'.$col['field']['name'] !!}">{!! $col['field']['value'] !!}</div>
        @endforeach

        <div class="summary_col_{!! $row['id'] !!} col_options">
            @foreach($row['options'] as $option)
                <button title="{!! \Lang::get($row['modulename'].'.'.$option['title']) !!}"
                        type="button"
                        data-row="{!! $row['modulename'].'_'.$row['id'] !!}"
                        class="@if(isset($option['class'])){{ $option['class'] }}@endif row_btn">
                        <div class="{!! $option['icon'] !!}"></div>
                </button>
            @endforeach
        </div>
    </li>

    <?php
    //check if the form has errors, if so, slide down the form to show the message
    $error = false;
    if($errors->all()){
        foreach($row['item_form']['formfields'] as $name => $item_field){
            if($errors->default->first($row['modulename'].'.'.$row['id'].'.'.$name)){
                $error = true;
            }
        }
    }
    ?>

    <li class="item_form form_{!! $row['modulename'].'_'.$row['id'] !!}"  @if($error) style="display:block;" @endif >
        @foreach($row['item_form']['formfields'] as $item_field)
        {!! $item_field['field'] !!}
        @endforeach
    <label>&nbsp;</label>
        <button type="button"
                class="btnMultipleSave big_button"
                data-row="{!! $row['modulename'].'_'.$row['id'] !!}"
                data-id="{!! $row['id'] !!}" >
            <div class="icon-save"></div>
            <span>{!! \Lang::get('cms.Save') !!}</span>
        </button>
        <button type="button"
                class="btnMultipleCancel big_button"
                data-row="{!! $row['modulename'].'_'.$row['id'] !!}"
                data-id="{!! $row['id'] !!}">
            <div class="icon-cancel"></div>
            <span>{!! \Lang::get('cms.Cancel') !!}</span>
        </button>
    </li>
