
    <select class="input_select" name="field[{{ $row }}][input]" id="field_input_{{ $row }}" data-row="{{ $row }}">
        <option value="">---</option>
        <option value="checkbox"  @if(isset($field['input']) && $field['input'] == 'checkbox') selected @endif>checkbox</option>
        <option value="color"  @if(isset($field['input']) && $field['input'] == 'color') selected @endif>color</option>
        <option value="date"  @if(isset($field['input']) && $field['input'] == 'date') selected @endif>date</option>
        <option value="datetime"  @if(isset($field['input']) && $field['input'] == 'datetime') selected @endif>datetime</option>
        <option value="email"  @if(isset($field['input']) && $field['input'] == 'email') selected @endif>email</option>
        <option value="file"  @if(isset($field['input']) && $field['input'] == 'file') selected @endif>file</option>
        <option value="files"  @if(isset($field['input']) && $field['input'] == 'files') selected @endif>files</option>
        <option value="foreign"  @if(isset($field['input']) && $field['input'] == 'foreign') selected @endif>foreign</option>
        <option value="hidden"  @if(isset($field['input']) && $field['input'] == 'hidden') selected @endif>hidden</option>
        <option value="html"  @if(isset($field['input']) && $field['input'] == 'html') selected @endif>html</option>
        <option value="icon"  @if(isset($field['input']) && $field['input'] == 'icon') selected @endif>icon</option>
        <option value="image"  @if(isset($field['input']) && $field['input'] == 'image') selected @endif>image</option>
        <option value="images"  @if(isset($field['input']) && $field['input'] == 'images') selected @endif>images</option>
        <option value="language"  @if(isset($field['input']) && $field['input'] == 'language') selected @endif>language</option>
        <option value="multiGroupedCheckbox"  @if(isset($field['input']) && $field['input'] == 'multiGroupedCheckbox') selected @endif>multiGroupedCheckbox</option>
        <option value="password"  @if(isset($field['input']) && $field['input'] == 'password') selected @endif>password</option>
        <option value="radio"  @if(isset($field['input']) && $field['input'] == 'radio') selected @endif>radio</option>
        <option value="select"  @if(isset($field['input']) && $field['input'] == 'select') selected @endif>listmenu</option>
        <option value="text" @if(isset($field['input']) && $field['input'] == 'text') selected @endif>text</option>
        <option value="textarea"  @if(isset($field['input']) && $field['input'] == 'textarea') selected @endif>textarea</option>
        <option value="time"  @if(isset($field['input']) && $field['input'] == 'time') selected @endif>time</option>
        <option value="video"  @if(isset($field['input']) && $field['input'] == 'video') selected @endif>video</option>
        <option value="videos"  @if(isset($field['input']) && $field['input'] == 'videos') selected @endif>video's</option>
    </select>
    <div class="row fieldrow_{{$row}}"><label class="text">Label</label>
        <input type="text" name="field[{{ $row }}][label]" id="field_label_{{ $row }}"
               value="@if(isset($field['label'])){{ $field['label'] }}@endif"
               ></div>