<?php

//dd($data);

?>
            {!! Form::open(["method" => $form['method'], "url" => $form['url'], "id" => "recipe_form"]) !!}

            {{-- NAME --}}
            <div class="formRow text">
                {!! Form::label('name', 'Name', ['class' => 'required']) !!}
                {!! Form::text('name', $data['recipe']->moduleName, ['id' => 'name']) !!}
                <span class="error_msg name">{!! $errors->first('name') !!}@if(isset($message)){!! $message !!}@endif</span>
            </div>

            {{-- PARENT TABLE --}}
            <div class="formRow text">
                {!! Form::label('parent_table', 'Parent table') !!}
                @if(isset($data['recipe']->parent_table)){!! Form::text('parent_table', $data['recipe']->parent_table, ['id' => 'parent_table']) !!}
                @else{!! Form::text('parent_table', '', ['id' => 'parent_table']) !!}
                @endif
                <span class="error_msg parent_table">{!! $errors->first('parent_table') !!}</span>
            </div>

            {{-- ADD --}}
            @if(isset($data['recipe']->add))
                <div class="formRow checkbox">
                    <label>Add</label>
                    {!! Form::checkbox('add', '1', $data['recipe']->add == '1' ? true : false, ['id' => 'add']) !!}
                    <label class="checkbox_style" for="add"><span></span></label>
                    <span class="error_msg">{!! $errors->first('add') !!}</span>
                    <div class="info">Provides an add option</div>
                </div>
            @endif

            {{-- EDIT --}}
            @if(isset($data['recipe']->edit))
                <div class="formRow checkbox">
                    <label>Edit</label>
                    {!! Form::checkbox('edit', '1', $data['recipe']->edit == '1' ? true : false, ['id' => 'edit']) !!}
                    <label class="checkbox_style" for="edit"><span></span></label>
                    <span class="error_msg">{!! $errors->first('edit') !!}</span>
                    <div class="info">Provides an edit option</div>
                </div>
            @endif

            {{-- DELETE --}}
            @if(isset($data['recipe']->edit))
                <div class="formRow checkbox">
                    <label>Delete</label>
                    {!! Form::checkbox('delete', '1', $data['recipe']->delete == '1' ? true : false, ['id' => 'delete']) !!}
                    <label class="checkbox_style" for="delete"><span></span></label>
                    <span class="error_msg">{!! $errors->first('delete') !!}</span>
                    <div class="info">Provides a delete option</div>
                </div>
            @endif

            @if(isset($data['recipe']->activatable))
            {{-- ACTIVATABLE --}}
                <div class="formRow checkbox">
                    <label>Activatable</label>
                    {!! Form::checkbox('activatable', '1', $data['recipe']->activatable == '1' ? true : false, ['id' => 'activatable']) !!}
                    <label class="checkbox_style" for="activatable"><span></span></label>
                    <span class="error_msg">{!! $errors->first('activatable') !!}</span>
                    <div class="info">Adds an 'active' field to the table for on/off switching</div>
                </div>
            @endif

            {{-- PROTECTABLE --}}
            @if(isset($data['recipe']->protectable))
                <div class="formRow checkbox">
                    <label>Protectable</label>
                    {!! Form::checkbox('protectable', '1', $data['recipe']->protectable == '1' ? true : false, ['id' => 'protectable']) !!}
                    <label class="checkbox_style" for="protectable"><span></span></label>
                    <span class="error_msg">{!! $errors->first('protectable') !!}</span>
                    <div class="info">Adds a 'protect' field to the table for disabling edit and delete options for unauthorized users</div>
                </div>
            @endif

            {{-- TIMESTAMPS --}}
            @if(isset($data['recipe']->timestamps))
                <div class="formRow checkbox">
                    <label>Timestamps</label>
                    {!! Form::checkbox('timestamps', '1', $data['recipe']->timestamps == '1' ? true : false, ['id' => 'timestamps']) !!}
                    <label class="checkbox_style" for="timestamps"><span></span></label>
                    <span class="error_msg">{!! $errors->first('timestamps') !!}</span>
                    <div class="info">Adds timestamp fields for creation date and modification date to the table</div>
                </div>
            @endif

            {{-- SORTABLE --}}
            @if(isset($data['recipe']->sortable) || isset($data['recipe']->nestable))
                <div class="formRow checkbox">
                    <label>Sortable</label>
                    {!! Form::checkbox('sortable', '1', $data['recipe']->sortable == '1' || $data['recipe']->nestable == '1' ? true : false, ['id' => 'sortable']) !!}
                    <label class="checkbox_style" for="sortable"><span></span></label>
                    <span class="error_msg">{!! $errors->first('sortable') !!}</span>
                    <div class="info">Adds nestable fields tot the table for sorting items</div>
                </div>
                <div class="formRow radio sortable_levels">
                    <label>Sortable levels</label>
                    {!! Form::radio('sortable_levels', 'single', $data['recipe']->sortable == 'true' ? true : false, ['id' => 'sortable_levels_1']) !!}
                    <label class="radio_style" for="sortable_levels_1"><span></span></label>
                    <div class="info">Single</div>
                    {!! Form::radio('sortable_levels', 'multiple', $data['recipe']->nestable == 'true' ? true : false, ['id' => 'sortable_levels_2']) !!}
                    <label class="radio_style" for="sortable_levels_2"><span></span></label>
                    <div class="info">Multiple</div>
                    <span class="error_msg">{!! $errors->first('sortable_levels') !!}</span>
                </div>
            @endif

            {{-- FIELDS --}}
            <div class="parentRow ">
                <div class="parentTitle" style="margin:7px 10px 0 15px; float:left;">
                    Fields
                </div>
                <button title="Add field" id="btnAddField" type="button" class="btnAdd row_btn" style="margin: 6px 2px;">
                    <div class="icon-add"></div>
                </button>
            </div>

            <section class="recipe">
                <table id="fields_table" class="fields">
                    <tbody>
                    <tr>
                        <th class="parentRow col_sort" style="width:30px;">
                            <button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>
                        </th>
                        <th class="parentRow name">Name</th>
                        <th class="parentRow type">Type</th>
                        <th class="parentRow input">Input</th>
                        <th class="parentRow inputoptions">Input options</th>
                        <th class="parentRow rules">Rules</th>
                        <th class="parentRow fieldoptions">Field options</th>
                        <th class="parentRow rowoptions">&nbsp;</th>
                    </tr>
                    <?php $n = 0; ?>
                    @foreach($data['recipe']->fields as $name => $field)
                        @include('recipes.recipes_fieldrow',['row' => $n, 'name' => $name, 'field' => $field])
                    <?php $n++; ?>
                    @endforeach
                    </tbody>
                </table>
            </section>

            {{-- FIELDS --}}

                {{-- RELATIONS COLUMN --}}
                @include('recipes.recipes_relations',['name' => $name, 'field' => $field])


            {!! Form::close() !!}
