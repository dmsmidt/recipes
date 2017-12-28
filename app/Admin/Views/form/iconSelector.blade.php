<div class="iconSelectDialog" style="display:block;">
    @foreach($selector['icons'] as $icon)
    <div class="icon {{ $icon['current'] }}" data-icon="{{ $icon['icon'] }}">
        <div class="{{ $icon['icon'] }}"></div>
    </div>
    @endforeach
    {{ $selector['script'] }}
</div>