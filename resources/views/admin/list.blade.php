@extends('admin.master')
@section('title', 'Admin Control Panel'.$pageConfig['title'])
@section('content')
    @include('admin.common.action-bar')
    <main id="main-list" class="container-fluid">
       <div class="d-grid gap-3">
            @if(AdminList::validatedIfExtraHeaderComponentExist($pageConfig))
                <x-dynamic-component :component="AdminList::getExtraHeaderComponentName($pageConfig)" />
            @endif
            @include('admin.common.search_bar')
        </div>
        @include('shared.notification')
        @if ($articles->isEmpty())
            <x-ui.alert  class='alert-info d-flex justify-content-center mt-3'>
                <div>{{trans('admin.message.no_item_found')}}</div>
            </x-ui.alert>
        @else
            <div class="table-container">
                <x-admin.lists.table.index :articles="$articles" :config="$pageConfig"></x-admin.lists.table.index>
            </div>
        @endif
        <x-admin.lists.pagination :articles="$articles"/>
    </main>
@endsection

@section('footerjs')
    <script src="{!! asset(config('maguttiCms.admin.path.plugins').'selectize/selectize.min.js')!!}"
            type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('.selectize').selectize({
                sortField: 'text'
            });
            $('.suggest-remote').selectize({
                valueField: 'id',
                labelField: 'value',
                searchField: 'value',
                sortField: 'text',
                load: function (query, callback) {
                    var obj = $(this)[0];
                    var cur_item = $('#' + obj.$input["0"].id)
                    if (!query.length) return callback();
                    $.ajax({
                        url: '{!! route('api.suggest') !!}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            q: query,
                            model: cur_item.data('model'),
                            value: cur_item.data('value'),
                            caption: cur_item.data('caption'),
                            searchFields: cur_item.data('fields'),
                            accessor: cur_item.data('accessor'),
                            where: cur_item.data('where')
                        },
                        error: function () {
                            callback();
                        },
                        success: function (res) {
                            callback(res);
                        }
                    });
                }
            });
        });
    </script>
@endsection
