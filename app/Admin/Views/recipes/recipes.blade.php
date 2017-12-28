@if(isset($index->error))
    <div class="error_msg">{{ $index->error }}</div>
@else

    {{-- DISPLAY INDEX --}}

    @if($data['display'] == 'index')
        @include('recipes.recipes_index',['data' => $data])
    @endif
    @if($data['display'] == 'create')
        @include('recipes.recipes_create',['data' => $data,'form' => ['url' => '/admin/recipes','method' => 'POST']])
    @endif
    @if($data['display'] == 'edit')
        @include('recipes.recipes_create',['data' => $data,'form' => ['url' => '/admin/recipes/'.strtolower(str_singular($data['recipe']->moduleName)), 'method' => 'PUT']])
    @endif

@endif

