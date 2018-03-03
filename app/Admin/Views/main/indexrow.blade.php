
{{-- ROWS --}}
@if(isset($rows) && count($rows) > 0)
    @foreach($rows as $row)
        @if(Session::get('user.role_id') > 2 && $row['protect'])

        @else
            <li class="dd-item @if(isset($row['class'])){{ $row['class'] }}@endif"
                data-id="{{ $row['id'] }}"
                data-parent_id="{{ $row['parent_id'] }}"
                data-lft="{{ $row['lft'] }}"
                data-rgt="{{ $row['rgt'] }}"
                data-level="{{ $row['level'] }}">

                {{-- SORT --}}
                <div class="dd-handle dd3-handle">
                    @if(isset($row['sortable']) || isset($row['nestable']))
                        <div class="col_sort">
                            <button
                                title="{{ Lang::get('admin.Drag the row to re-order') }}"
                                type="button"
                                class="btnSortable row_btn">
                                <div class="@if(isset($row['sortable']))fas fa-arrows-alt-v @endif @if(isset($row['nestable']))fas fa-arrows-alt @endif"></div>
                            </button>
                        </div>
                    @else
                        <div class="col_sort">&nbsp;</div>
                    @endif

                </div>

                <div class="dd3-content">
                <?php $n = 0; ?>
                    @foreach($row['columns'] as $column)
                        <div class="col_{{ $column['input'] }}">@if($n == 0 && isset($row['edit']['url']) && !empty($row['edit']['url']) && !$row['protect'])<a href="{{ $row['edit']['url'] }}">@endif{!! $column['value'] !!}</a></div>
                        <?php $n++; ?>
                    @endforeach

                    {{-- OPTIONS --}}
                    <div class="col_options">

                        {{-- EDIT --}}
                        @if(isset($row['edit']) && !$row['protect'])
                        <button
                            title="{{ Lang::get($moduleName.'.'.$row['edit']['title']) }}"
                            type="button"
                            data-url="{{ $row['edit']['url'] }}"
                            data-module="{{ $row['edit']['module_name'] }}"
                            data-id="{{ $row['id'] }}"
                            data-action = "{{ $row['edit']['action'] }}"
                            class="{{ $row['edit']['class'] }} row_btn">
                            <div class="far fa-edit"></div>
                        </button>
                        @endif

                        {{-- DELETE --}}
                        @if(isset($row['delete']) && !$row['protect'])
                        <button
                            title="{{ Lang::get($moduleName.'.'.$row['delete']['title']) }}"
                            type="button"
                            data-url="{{ $row['delete']['url'] }}"
                            data-module="{{ $row['delete']['module_name'] }}"
                            data-id="{{ $row['id'] }}"
                            data-dialog = "{{ $row['delete']['action'] }}"
                            class="{{ $row['delete']['class'] }} row_btn">
                            <div class="far fa-trash-alt"></div>
                        </button>
                        @endif

                        {{-- ACTIVE --}}
                        @if(isset($row['activatable']))
                        <button
                            title="{{ Lang::get('admin.On/Off switch') }}"
                            type="button"
                            data-url="{{ $row['activatable']['url'] }}"
                            data-module="{{ $row['activatable']['module_name'] }}"
                            data-id="{{ $row['id'] }}"
                            data-action = "{{ $row['activatable']['action'] }}"
                            class="{{ $row['activatable']['class'] }} row_btn">
                            <div class="{{ $row['active'] ? 'fas fa-toggle-on' : 'fas fa-toggle-off' }}"></div>
                        </button>
                        @endif

                        {{-- PROTECT --}}
                        @if(isset($row['protectable']) && Session::get('user.role_id') == 1)
                        <button
                            title="{{ Lang::get('admin.Protection On/Off') }}"
                            type="button"
                            data-url="{{ $row['protectable']['url'] }}"
                            data-module="{{ $row['protectable']['module_name'] }}"
                            data-id="{{ $row['id'] }}"
                            data-action = "{{ $row['protectable']['action'] }}"
                            class="{{ $row['protectable']['class'] }} row_btn">
                            <div class="{{ $row['protect'] ? 'fas fa-lock' : 'fas fa-unlock' }}"></div>
                        </button>
                        @endif
                    </div>
                </div>
            @if(!empty($row['children']))
                <ol class="dd-list">
                    @include('main.indexrow', ['rows' => $row['children']])
                </ol>
            @endif
        @endif
    </li>
    @endforeach
@endif


