<div class="bottom-bar">
    @if($bottombar)
        <a href="{{ $bottombar->save['href'] }}"><button type="button" class="btn big_button"><i class="fa fa-check"></i><span>{{\Lang::get('admin.Save')}}</span></button></a>
        <a href="{{ $bottombar->cancel['href'] }}"><button type="button" class="btnCancel big_button"><i class="fa fa-times"></i><span>{{\Lang::get('admin.Cancel')}}</span></button></a>
    @endif
</div>