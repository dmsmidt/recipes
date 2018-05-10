    <select class="type_select" name="field[{{ $row }}][type]" id="field_type_{{ $row }}" data-row="{{ $row }}">
        <option value="">---</option>
        <option value="increments" @if(isset($field['type']) && $field['type'] == 'increments') selected @endif>increments</option>
        <option value="biginteger" @if(isset($field['type']) && $field['type'] == 'biginteger') selected @endif>biginteger</option>
        <option value="integer" @if(isset($field['type']) && $field['type'] == 'integer') selected @endif>integer</option>
        <option value="tinyinteger" @if(isset($field['type']) && $field['type'] == 'tinyinteger') selected @endif>tinyinteger</option>
        <option value="boolean" @if(isset($field['type']) && $field['type'] == 'boolean') selected @endif>boolean</option>
        <option value="decimal" @if(isset($field['type']) && $field['type'] == 'decimal') selected @endif>decimal</option>
        <option value="double" @if(isset($field['type']) && $field['type'] == 'double') selected @endif>double</option>
        <option value="float_number" @if(isset($field['type']) && $field['type'] == 'float_number') selected @endif>float</option>
        <option value="time" @if(isset($field['type']) && $field['type'] == 'time') selected @endif>time</option>
        <option value="date" @if(isset($field['type']) && $field['type'] == 'date') selected @endif>date</option>
        <option value="datetime" @if(isset($field['type']) && $field['type'] == 'datetime') selected @endif>datetime</option>
        <option value="timestamp" @if(isset($field['type']) && $field['type'] == 'timestamp') selected @endif>timestamp</option>
        <option value="enum" @if(isset($field['type']) && $field['type'] == 'enum') selected @endif>enum</option>
        <option value="foreign" @if(isset($field['type']) && $field['type'] == 'foreign') selected @endif>foreign</option>
        <option value="translation" @if(isset($field['type']) && $field['type'] == 'translation') selected @endif>translation</option>
        <option value="longtext" @if(isset($field['type']) && $field['type'] == 'longtext') selected @endif>longtext</option>
        <option value="text" @if(isset($field['type']) && $field['type'] == 'text') selected @endif>text</option>
        <option value="email" @if(isset($field['type']) && $field['type'] == 'email') selected @endif>email</option>
        <option value="password" @if(isset($field['type']) && $field['type'] == 'password') selected @endif>password</option>
        <option value="varchar" @if(isset($field['type']) && $field['type'] == 'varchar') selected @endif>varchar</option>
    </select>
    {{-- TYPE OPTIONS --}}
        @include('recipes.recipes_typeoptions',['row' => $row, 'field' => $field])
    {{-- /TYPE OPTIONS --}}
