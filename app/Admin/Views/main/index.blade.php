@if(isset($index->error))
    <div class="error_msg">{{ $index->error }}</div>
@else
        {{-- HEADERS --}}
        <ul class="overview">
            <li class="headers">
                <div class="col_sort"></div>
                @foreach($index->headers as $col)
                <div class="col_{{ $col['class'] }}">{{ Lang::get($moduleName.'.'.$col['text']) }}</div>
                @endforeach
                <div class="col_options">{{ Lang::get($moduleName.'.Options') }}</div>
            </li>
        </ul>

        <div class="dd"
             @if(isset($index->levels))
                id="nestable" data-levels="{{ $index->levels }}"
             @endif
             >

            {{-- ROWS --}}
            <ol class="dd-list">
                @include('main.indexrow',['rows' => $index->rows])
            </ol>

        </div>
@endif

