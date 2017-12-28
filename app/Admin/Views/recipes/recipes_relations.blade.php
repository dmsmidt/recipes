<div class="parentRow ">
    <div class="parentTitle" style="margin:7px 10px 0 15px; float:left;">Relations</div>
    <select style="height: 22px;float: left;margin: 4px 0;" name="relationtype" id="relationtype">
        <option value="has_one">has one</option>
        <option value="has_many">has many</option>
        <option value="many_many">many many</option>
    </select>
    <button title="Add relation" id="btnAddRelation" type="button" class="row_btn" style="float:left; margin: 6px 2px;">
        <div class="icon-add"></div>
    </button>
</div>
<div class="parentRow "><div class="parentTitle" style="margin:7px 50px 0 38px; float:left;">Has one</div></div>
<section class="recipe">
    <table class="fields hasone_table">
        <tbody>
        <tr>
            <th class="parentRow col_sort" style="width:30px;">
                {{--<button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>--}}
            </th>
            <th class="parentRow " style="width:10%">Field</th>
            <th class="parentRow " style="width:15%">Related table.field</th>
            <th class="parentRow " style="width:calc(75% - 30px)"></th>
        </tr>
        @if(isset($data['recipe']->has_one))
            <?php $n = 0; ?>
            @foreach($data['recipe']->has_one as $field => $relation)
            <tr>
                <td></td>
                {{-- HAS ONE FIELD COLUMN --}}
                <td><input type="text" name="has_one[{{ $n }}][field]" id="has_one_field_{{ $n }}" value="{{ $field }}"></td>
                {{-- HAS ONE RELATED TABLE FIELD COLUMN --}}
                <td><input type="text" name="has_one[{{ $n }}][tablefield]" id="has_one_tablefield_{{ $n }}" value="{{ $relation }}"></td>
            </tr>
            <?php $n++; ?>
            @endforeach
        @endif
        </tbody>
    </table>
</section>


<div class="parentRow "><div class="parentTitle" style="margin:7px 50px 0 38px; float:left;">Has many</div></div>
<section class="recipe">
    <table class="fields hasmany_table">
        <tbody>
        <tr>
            <th class="parentRow col_sort" style="width:30px;">
                {{--<button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>--}}
            </th>
            <th class="parentRow " style="width:10%">Field</th>
            <th class="parentRow " style="width:15%">Related table.field</th>
            <th class="parentRow " style="width:calc(75% - 30px)"></th>
        </tr>
        @if(isset($data['recipe']->has_many))
            <?php $n = 0; ?>
            @foreach($data['recipe']->has_many as $field => $relation)
            <tr>
                <td></td>
                {{-- HAS MANY FIELD COLUMN --}}
                <td><input type="text" name="has_many[{{ $n }}][field]" id="has_many_field_{{ $n }}" value="{{ $field }}"></td>
                {{-- HAS MANY RELATED TABLE FIELD COLUMN --}}
                <td><input type="text" name="has_many[{{ $n }}][tablefield]" id="has_many_tablefield_{{ $n }}" value="{{ $relation }}"></td>
            </tr>
            <?php $n++; ?>
            @endforeach
        @endif
        </tbody>
    </table>
</section>


<div class="parentRow "><div class="parentTitle" style="margin:7px 50px 0 38px; float:left;">Many many</div></div>
<section class="recipe">
    <table class="fields manymany_table">
        <tbody>
        <tr>
            <th class="parentRow col_sort" style="width:30px;">
                {{--<button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>--}}
            </th>
            <th class="parentRow " style="width:10%">Field</th>
            <th class="parentRow " style="width:15%">Related table.field</th>
            <th class="parentRow " style="width:calc(75% - 30px)"></th>
        </tr>
        @if(isset($data['recipe']->many_many))
            <?php $n = 0; ?>
            @foreach($data['recipe']->many_many as $field => $relation)
            <tr>
                <td></td>
                {{-- MANY MANY FIELD COLUMN --}}
                <td><input type="text" name="many_many[{{ $n }}][field]" id="many_many_field_{{ $n }}" value="{{ $field }}"></td>
                {{-- MANY MANY RELATED TABLE FIELD COLUMN --}}
                <td><input type="text" name="many_many[{{ $n }}][tablefield]" id="many_many_tablefield_{{ $n }}" value="{{ $relation }}"></td>
            </tr>
            <?php $n++; ?>
            @endforeach
        @endif
        </tbody>
    </table>
</section>