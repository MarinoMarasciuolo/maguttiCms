
    {!! Form::open(['id' => 'search_form', 'name'=>'search_form', 'method' => 'GET']) !!}
    <div id="search-bar" class="card mb-3">
        <x-admin.partial.select-item-per-page></x-admin.partial.select-item-per-page>
        @if(isset($pageConfig['field_searchable']))
        @foreach ( cmsUserValidateActionRoles($pageConfig['field_searchable']) as $key => $search_item )
            <div class="{{data_get($search_item,'class')}}">
                @if ($search_item['type'] == 'relation')
                    <x-ui.selectable :name="$key" :config="collect($search_item)"></x-ui.selectable>
                @elseif ($search_item['type'] == 'suggest')
                    <x-ui.suggestable :name="$key" :config="collect($search_item)" class="form-control"></x-ui.suggestable>
                @else
                    <x-ui.input :name="$key" :config="collect($search_item)" class="form-control"></x-ui.input>
                @endif
            </div>
        @endforeach
        @endif
        <div>
            <button type="submit" class="btn btn-default">
                {{icon('search')}} {{ trans('admin.label.search') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}

