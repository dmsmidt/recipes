

        <input type="checkbox" value="1" name="field[{{ $row }}][hidden]" id="field_hidden_{{ $row }}" @if(isset($data['recipe']->hidden) && in_array($name,$data['recipe']->hidden)) checked @endif><label style="vertical-align: sub">Hidden</label>
        <input type="checkbox" value="1" name="field[{{ $row }}][summary]" id="field_summary_{{ $row }}" @if(isset($data['recipe']->summary) && in_array($name,$data['recipe']->summary)) checked @endif><label style="vertical-align: sub">Summary</label>
        <input type="checkbox" value="1" name="field[{{ $row }}][fillable]" id="field_fillable_{{ $row }}" @if(isset($data['recipe']->fillable) && in_array($name,$data['recipe']->fillable)) checked @endif><label style="vertical-align: sub">Fillable</label>
        <input type="checkbox" value="1" name="field[{{ $row }}][guarded]" id="field_guarded_{{ $row }}" @if(isset($data['recipe']->guarded) && in_array($name,$data['recipe']->guarded)) checked @endif><label style="vertical-align: sub">Guarded</label>
        <input type="checkbox" value="1" name="field[{{ $row }}][scoped]" id="field_scoped_{{ $row }}" @if(isset($data['recipe']->scoped) && in_array($name,$data['recipe']->scoped)) checked @endif><label style="vertical-align: sub">Scoped</label>

