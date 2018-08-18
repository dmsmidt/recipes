    {{-- DISMANTLE RULES STRING --}}
    <?php

    if(isset($field['rule']) && !empty($field['rule']))
    {
        $_rules = explode('|',$field['rule']);
        $rules = [];
        foreach($_rules as $key=>$rule){
            if(strpos($rule,'required') !== false){
                $rules['required'] = true;
            }elseif(strpos($rule,'accepted') !== false){
                            $rules['accepted'] = true;
            }elseif(strpos($rule,'confirmed') !== false){
                            $rules['confirmed'] = true;
            }elseif(strpos($rule,'unique') !== false){
                $rule_parts = explode(':',$rule);
                $rule_table_parts = explode(',',$rule_parts[1]);
                $rules['unique'] = ['table' => $rule_table_parts[0],
                                    'field' => $rule_table_parts[1]
                                   ];
            }elseif(strpos($rule,'email') !== false){
                $rules['email'] = true;
            }elseif(strpos($rule,'image') !== false){
                $rules['image'] = true;
            }elseif(strpos($rule,'integer') !== false){
                $rules['integer'] = true;
            }elseif(strpos($rule,'numeric') !== false){
                $rules['numeric'] = true;
            }elseif(strpos($rule,'date_format') !== false){
            //alleen bij eerste dubbele punt splitten
                $rule_parts = strstr($rule,':',true);
                $rules['date_format'] = $rule_parts;
            }elseif(strpos($rule,'size') !== false){
                $rule_parts = explode(':',$rule);
                $rules['size'] = $rule_parts[1];
            }elseif(strpos($rule,'min') !== false){
                $rule_parts = explode(':',$rule);
                $rules['min'] = $rule_parts[1];
            }elseif(strpos($rule,'max') !== false){
                $rule_parts = explode(':',$rule);
                $rules['max'] = $rule_parts[1];
            }elseif(strpos($rule,'regex') !== false){
                $rule_parts = explode(':',$rule);
                $rules['regex'] = $rule_parts[1];
            }
        }
        //echo '<pre>'.print_r($rules,true).'</pre>';
    }

    ?>
    {{-- RULE SELECT --}}
    <select name="relationtype" id="relationtype_{{ $row }}" style="float:left;width:auto;">
        <option value="">---</option>
        <option value="required">required</option>
        <option value="accepted">accepted</option>
        <option value="confirmed">confirmed</option>
        <option value="date_format">date format</option>
        <option value="unique">unique</option>
        <option value="email">email</option>
        <option value="integer">integer</option>
        <option value="numeric">numeric</option>
        <option value="size">size</option>
        <option value="min">min</option>
        <option value="max">max</option>
        <option value="regex">regex</option>
    </select>

    {{-- ADD BUTTON --}}
    <button title="Add rule" type="button" class="row_btn btnAddRule" data-row="{{ $row }}" style="margin: 4px 2px; background-color: #FE7239; padding: 4px 6px; color: #fff; border-radius: 50%;">
        <div class="fas fa-plus"></div>
    </button>

    <div class="row fieldrow_{{$row}}">

        {{-- REQUIRED INPUT --}}
        <div class="input_required_{{ $row }}" @if(!isset($rules['required']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|required]" id="field_rule|required_{{ $row }}" @if(isset($rules['required']) && $rules['required']) checked @endif>
            <label style="vertical-align: sub; width:5%">Required</label>
        </div>

        {{-- ACCEPTED INPUT --}}
        <div class="input_accepted_{{ $row }}" @if(!isset($rules['accepted']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|accepted]" id="field_rule|accepted_{{ $row }}" @if(isset($rules['accepted']) && $rules['accepted']) checked @endif>
            <label style="vertical-align: sub; width:5%">Accepted</label>
        </div>

        {{-- CONFIRMED INPUT --}}
        <div class="input_confirmed_{{ $row }}" @if(!isset($rules['confirmed']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|confirmed]" id="field_rule|confirmed_{{ $row }}" @if(isset($rules['confirmed']) && $rules['confirmed']) checked @endif>
            <label style="vertical-align: sub; width:5%">Confirmed</label>
        </div>

        {{-- UNIQUE INPUT --}}
        <div class="input_unique_{{ $row }}" @if(!isset($rules['unique']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|unique]"
            id="field_rule|unique_{{ $row }}" @if(isset($rules['unique']) && $rules['unique']) checked @endif><label style="vertical-align: sub">Unique</label>
        </div>

        {{-- UNIQUE TABLE INPUT --}}
        <div class="input_unique_{{ $row }}" @if(!isset($rules['unique']))style="display:none;"@endif><label class="text">Tabel</label>
            <input type="text" name="field[{{ $row }}][uniquetable]" id="field_uniquetable_{{ $row }}" value="@if(isset($rules['unique']) && isset($rules['unique']['table'])){{ $rules['unique']['table'] }}@endif">
        </div>

        {{-- UNIQUE TABLE FIELD INPUT --}}
        <div class="input_unique_{{ $row }}" @if(!isset($rules['unique']))style="display:none;"@endif><label class="text">Column</label>
            <input type="text" name="field[{{ $row }}][uniquecolumn]" id="field_uniquecolumn_{{ $row }}" value="@if(isset($rules['unique']) && isset($rules['unique']['field'])){{ $rules['unique']['field'] }}@endif">
        </div>

        {{-- EMAIL INPUT --}}
        <div class="input_email_{{ $row }}" @if(!isset($rules['email']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|email]" id="field_rule|email_{{ $row }}" @if(isset($rules['email']) && $rules['email']) checked @endif>
            <label style="vertical-align: sub">Email</label>
        </div>

        {{-- IMAGE INPUT --}}
        <div class="input_image_{{ $row }}" @if(!isset($rules['image']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|image]" id="field_rule|image_{{ $row }}" @if(isset($rules['image']) && $rules['image']) checked @endif>
            <label style="vertical-align: sub">Image</label>
        </div>

        {{-- INTEGER INPUT --}}
        <div class="input_integer_{{ $row }}" @if(!isset($rules['integer']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|integer]" id="field_rule|integer_{{ $row }}" @if(isset($rules['integer']) && $rules['integer']) checked @endif>
            <label style="vertical-align: sub">Integer</label>
        </div>

        {{-- NUMERIC INPUT --}}
        <div class="input_numeric_{{ $row }}" @if(!isset($rules['numeric']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|numeric]" id="field_rule|numeric_{{ $row }}" @if(isset($rules['numeric']) && $rules['numeric']) checked @endif>
            <label style="vertical-align: sub">Numeric</label>
        </div>

        {{-- DATE FORMAT INPUT --}}
        <div class="input_date_format_{{ $row }}" @if(!isset($rules['date_format']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|date_format]" id="field_rule|date_format_{{ $row }}" @if(isset($rules['date_format']) && !empty( $rules['date_format'])) checked @endif><label class="checkbox_text_label">Date format</label>
            <input class="checkbox_text" type="text" name="field[{{ $row }}][rule|date_format]" id="field_rule|date_format_{{ $row }}" value="@if(isset($rules['date_format']) && !empty( $rules['date_format'])){{ $rules['date_format'] }}@endif">
        </div>

        {{-- SIZE INPUT --}}
        <div class="input_size_{{ $row }}" @if(!isset($rules['size']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|size]" id="field_rule|size_{{ $row }}" @if(isset($rules['size']) && !empty( $rules['size'])) checked @endif><label class="checkbox_text_label">Size</label>
            <input class="checkbox_text" type="text" name="field[{{ $row }}][rule|sizeval]" id="field_rule|sizeval_{{ $row }}" value="@if(isset($rules['size']) && !empty( $rules['size'])){{ $rules['size'] }}@endif">
        </div>

        {{-- MIN INPUT --}}
        <div class="input_min_{{ $row }}" @if(!isset($rules['min']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|min]" id="field_rule|min_{{ $row }}" @if(isset($rules['min']) && !empty( $rules['min'])) checked @endif><label  class="checkbox_text_label">Min</label>
            <input class="checkbox_text" type="text" name="field[{{ $row }}][rule|minval]" id="field_rule|minval_{{ $row }}" value="@if(isset($rules['min']) && !empty( $rules['min'])){{ $rules['min'] }}@endif">
        </div>

        {{-- MAX INPUT --}}
        <div class="input_max_{{ $row }}" @if(!isset($rules['max']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|max]" id="field_rule|max_{{ $row }}" @if(isset($rules['max']) && !empty( $rules['max'])) checked @endif><label class="checkbox_text_label">Max</label>
            <input class="checkbox_text" type="text" name="field[{{ $row }}][rule|maxval]" id="field_rule|maxval_{{ $row }}" value="@if(isset($rules['max']) && !empty( $rules['max'])){{ $rules['max'] }}@endif">
        </div>

        {{-- REGEX INPUT --}}
        <div class="input_regex_{{ $row }}" @if(!isset($rules['regex']))style="display:none;"@endif>
            <input type="checkbox" value="1" name="field[{{ $row }}][rule|regex]" id="field_ruleregex_{{ $row }}" @if(isset($rules['regex']) && !empty( $rules['regex'])) checked @endif><label class="checkbox_text_label">Regex</label>
            <input class="checkbox_text" type="text" name="field[{{ $row }}][rule|regexval]" id="field_rule|regexval_{{ $row }}" value="@if(isset($rules['regex']) && !empty( $rules['regex'])){{ $rules['regex'] }}@endif">
        </div>
    </div>