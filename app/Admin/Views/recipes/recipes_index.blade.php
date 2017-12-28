{{-- HEADERS --}}
<ul class="overview">
    <li class="headers">
        <div class="col_sort"></div>
        <div class="col_text">{{ Lang::get('recipes.Recipes') }}</div>
        <div class="col_text">{{ Lang::get('recipes.Model') }}</div>
        <div class="col_text">{{ Lang::get('recipes.Controller') }}</div>
        <div class="col_text">{{ Lang::get('recipes.Repository') }}</div>
        <div class="col_text">{{ Lang::get('recipes.Translations') }}</div>
        <div class="col_text">{{ Lang::get('recipes.Migration') }}</div>
        <div class="col_options">{{ Lang::get($moduleName.'.Options') }}</div>
    </li>
</ul>

<div class="dd">

    {{-- ROWS --}}
    <ol class="dd-list">
        @foreach($data['recipes'] as $row)
        <li class="dd-item">

            {{-- SORT --}}
            <div class="dd-handle dd3-handle">
                <div class="col_sort">&nbsp;</div>
            </div>

            <div class="dd3-content">

                <div class="col_text"><a href="/admin/recipes/{{ $row['name'] }}/edit">{!! $row['class'] !!}</a></div>
                <div class="col_text">
                    <button data-recipe="{{$row['name']}}" type="button" class="row_btn btnModelUpdate" style="margin:0;">@if($row['model'])
                        <div class="icon-checkbox2"></div>@else<div class="icon-checkbox3"></div>@endif
                    </button>
                </div>
                <div class="col_text">
                    <button data-recipe="{{$row['name']}}" type="button" class="row_btn btnControllerUpdate" style="margin:0;">@if($row['controller'])
                        <div class="icon-checkbox2"></div>@else<div class="icon-checkbox3"></div>@endif
                    </button>
                </div>
                <div class="col_text">
                    <button data-recipe="{{$row['name']}}" type="button" class="row_btn btnRepositoryUpdate" style="margin:0;">@if($row['repository'])
                        <div class="icon-checkbox2"></div>@else<div class="icon-checkbox3"></div>@endif
                    </button>
                </div>
                <div class="col_text">
                    <button data-recipe="{{$row['name']}}" type="button" class="row_btn btnTranslationsUpdate" style="margin:0;">@if($row['translations'])
                        <div class="icon-checkbox2"></div>@else<div class="icon-checkbox3"></div>@endif
                    </button>
                </div>
                <div class="col_text">
                    <button data-recipe="{{$row['name']}}" type="button" class="row_btn btnMigrate" style="margin:0;">@if($row['table'])
                        <div class="icon-checkbox2""></div>@else<div class="icon-checkbox3"></div>@endif
                    </button>
                </div>

                {{-- OPTIONS --}}
                <div class="col_options">
                    {{-- BACKUP --}}
                    <button
                        title="{{ Lang::get('recipes.Backup Recipe and corresponding classes') }}"
                        type="button"
                        data-recipe="{{$row['name']}}"
                        class="btnBackupRecipe row_btn">
                        <i class="fa fa-clone"></i>
                    </button>
                    {{-- EDIT --}}
                    <button
                        title="{{ Lang::get('recipes.Edit recipe') }}"
                        type="button"
                        data-url="/admin/recipes/{{ $row['name'] }}/edit"
                        data-module="recipes"
                        data-id=""
                        data-action = "get"
                        class="btnEdit row_btn">
                        <i class="fa fa-edit"></i>
                    </button>
                    {{-- DELETE CLASSES --}}
                    <button
                        title="{{ Lang::get('recipes.Delete all corresponding classes') }}"
                        type="button"
                        data-recipe="{{$row['name']}}"
                        class="btnDeleteClasses row_btn">
                        <i class="fa fa-trash-o"></i>
                    </button>

                </div>
            </div>
        </li>
        @endforeach
    </ol>

</div>

{{-- dd($data) --}}
