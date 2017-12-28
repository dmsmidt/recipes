{{-- HEADERS --}}
<ul class="overview">
    <li class="headers">
        <div class="col_sort"></div>
        <div class="col_text">{{ Lang::get($moduleName.'.Name') }}</div>
        <div class="col_text">{{ Lang::get($moduleName.'.Value') }}</div>
        <div class="col_options">{{ Lang::get('admin.Options') }}</div>
    </li>
</ul>

<div class="dd">

{{-- ROWS --}}
<ol class="dd-list">
    @include('main.indexrow',['rows' => $index->rows])
</ol>

</div>