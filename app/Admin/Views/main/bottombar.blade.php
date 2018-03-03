<div class="bottom-bar">
    @if($bottombar)
        @if(isset($bottombar->save))<a href="{{ $bottombar->save['href'] }}"><button type="button" class="btn big_button"><i class="fas fa-save"></i><span>{{\Lang::get('admin.Save')}}</span></button></a>@endif
        @if(isset($bottombar->cancel))<a href="{{ $bottombar->cancel['href'] }}"><button type="button" class="btnCancel big_button"><i class="fas fa-ban"></i><span>{{\Lang::get('admin.Cancel')}}</span></button></a>@endif
    @endif
</div>