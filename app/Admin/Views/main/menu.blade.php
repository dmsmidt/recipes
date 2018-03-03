
<section class="mainmenu">

    <!-- flags -->
    <div class="flags">
        @foreach($topbar->languages as $language)
            <button type="button" class="btnLang @if(Session::get('language.default_abbr') && Session::get('language.default_abbr') == $language['abbr']) active @endif" data-lang="{{ $language['abbr'] }}">
                <div class="flag-{{ $language['abbr'] }}"></div>
            </button>
        @endforeach
    </div>

    <!-- main buttons -->
    <div class="main_buttons">
        @if(isset($mainmenu))
            @foreach($mainmenu as $item)
                <a href="{{$item->url}}" class="main_button @if($item->current) active @endif" data-module="{{$item->name}}">
                    <i class="{{$item->icon}}"></i><span>{{ucfirst($item->text)}}</span>
                </a>
            @endforeach
        @endif
    </div>
    <!--/main buttons -->

</section>