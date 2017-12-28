
<div class="top-bar">

    {{-- TITLE --}}
    <h1>{{ $topbar->title }}</h1>

    {{-- BUTTONS --}}
    @if(isset($topbar->buttons) && count($topbar->buttons))
        @foreach($topbar->buttons as $button)
             @if(isset($button['href']) && !empty($button['href']))
                <a href="{{ $button['href'] }}">
             @endif
                    <button type="button" class="{{ $button['classes'] }}"><i class="fa {{ $button['icon'] }}"></i><span>{{ $button['text'] }}</span></button>
             @if(isset($button['href']) && !empty($button['href']))
                </a>
             @endif
        @endforeach
    @endif

</div>