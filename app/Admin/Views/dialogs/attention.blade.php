
    <div class="title"><div style="margin-right:10px;" class="@if(isset($data['icon'])&&!empty($data['icon'])){{$data['icon']}}@else fas fa-exclamation-triangle @endif"></div>
        {!! Lang::get('admin.Attention!') !!}
    </div>
    <div class="content">
    <ul>
        @foreach($data['messages'] as $message)
            <li><i class="
            @if($message['type'] == 'alert')fas fa-exclamation-triangle @endif
            @if($message['type'] == 'succes')fas fa-check-circle @endif
            @if($message['type'] == 'info')fas fa-info-circle @endif
            "></i><span>{{ $message['text'] }}</span></li>
        @endforeach
    </ul>
    </div>
    <div class="buttons">
        <button type="button" @if($data['page_refresh']) id="btnDialogCloseRefresh" @else id="btnDialogClose" @endif  class="big_button">{!! Lang::get('admin.Ok') !!}</button>
    </div>

