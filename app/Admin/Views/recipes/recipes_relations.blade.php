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

{{-- HAS ONE --}}
<div class="parentRow "><div class="parentTitle" style="margin:7px 50px 0 38px; float:left;">Has one</div></div>
<section class="recipe">
    <table class="fields hasone_table">
        <tbody>
        <tr>
            <th class="parentRow col_sort" style="width:30px;">
                {{--<button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>--}}
            </th>
            <th class="parentRow " style="width:10%">Table</th>
            <th class="parentRow " style="width:5%">Inverse</th>
            <th class="parentRow " style="width:calc(85% - 30px)"></th>
        </tr>
        @if(isset($data['recipe']->has_one))
            <?php $n = 0; ?>
            @foreach($data['recipe']->has_one as $relation)
            <tr>
                <td></td>
                {{-- HAS ONE FIELD COLUMN --}}
                <td><input type="text" name="has_one[{{ $n }}][table]" id="has_one_table_{{ $n }}" value="{{ $relation['table'] }}"></td>
                {{-- HAS ONE RELATED TABLE FIELD COLUMN --}}
                <td><input type="checkbox" name="has_one[{{ $n }}][inverse]" id="has_one_inverse_{{ $n }}" value="1" @if($relation['inverse']) checked @endif ></td>
                {{-- EMPTY COLUMN HEADER --}}
                <td>&nbsp;</td>
            </tr>
            <?php $n++; ?>
            @endforeach
        @endif
        </tbody>
    </table>
</section>

{{-- HAS MANY --}}
<div class="parentRow "><div class="parentTitle" style="margin:7px 50px 0 38px; float:left;">Has many</div></div>
<section class="recipe">
    <table class="fields hasmany_table">
        <tbody>
        <tr>
            <th class="parentRow col_sort" style="width:30px;">
                {{--<button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>--}}
            </th>
            <th class="parentRow " style="width:10%">Table</th>
            <th class="parentRow " style="width:5%">Inverse</th>
            <th class="parentRow " style="width:5%">Cascade</th>
            <th class="parentRow " style="width:calc(85% - 30px)"></th>
        </tr>
        @if(isset($data['recipe']->has_many))
            <?php $n = 0; ?>
            @foreach($data['recipe']->has_many as $relation)
            <tr>
                <td></td>
                {{-- HAS MANY FIELD COLUMN --}}
                <td><input type="text" name="has_many[{{ $n }}][table]" id="has_many_table_{{ $n }}" value="{{ $relation['table'] }}"></td>
                {{-- HAS MANY RELATED TABLE INVERSE --}}
                <td><input type="checkbox" name="has_many[{{ $n }}][inverse]" id="has_many_inverse_{{ $n }}" value="1" @if($relation['inverse']) checked @endif ></td>
                {{-- HAS MANY RELATED TABLE CASCADE --}}
                <td><input type="checkbox" name="has_many[{{ $n }}][cascade]" id="has_many_cascade_{{ $n }}" value="1" @if(isset($relation['cascade'])&&$relation['cascade']) checked @endif ></td>
            </tr>
            <?php $n++; ?>
            @endforeach
        @endif
        </tbody>
    </table>
</section>

{{-- MANY MANY --}}
<div class="parentRow "><div class="parentTitle" style="margin:7px 50px 0 38px; float:left;">Many many</div></div>
<section class="recipe">
    <table class="fields manymany_table">
        <tbody>
        <tr>
            <th class="parentRow col_sort" style="width:30px;">
                {{--<button class="btn table_btn" type="button" data-rowname="row"><div class="icon-tree-expand"></div></button>--}}
            </th>
            <th class="parentRow " style="width:10%">Table</th>
            <th class="parentRow " style="width:5%">&nbsp;</th>
            <th class="parentRow " style="width:5%">Cascade</th>
            <th class="parentRow " style="width:calc(85% - 30px)"></th>
        </tr>
        @if(isset($data['recipe']->many_many))
            <?php $n = 0; ?>
            @foreach($data['recipe']->many_many as $relation)
            <tr>
                <td></td>
                {{-- MANY MANY FIELD COLUMN --}}
                <td><input type="text" name="many_many[{{ $n }}][table]" id="many_many_table_{{ $n }}" value="{{ $relation['table'] }}"></td>
                {{-- EMPTY COLUMN --}}
                <td>&nbsp;</td>
                {{-- MANY MANY RELATED TABLE CASCADE --}}
                <td><input type="checkbox" name="many_many[{{ $n }}][cascade]" id="many_many_cascade_{{ $n }}" value="1" @if(isset($relation['cascade'])&&$relation['cascade']) checked @endif ></td>
            </tr>
            <?php $n++; ?>
            @endforeach
        @endif
        </tbody>
    </table>
</section>