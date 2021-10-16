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
            <x-ui.alert  class='alert-info d-flex justify-content-center'>
                <div>{{trans('admin.message.no_item_found')}}</div>
            </x-ui.alert>
        @else
            <div class="table-container">
                <form>
                    {{ csrf_field() }}
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    {{ AdminList::initList($pageConfig)->getListHeader() }}
                                    @if (AdminList::hasActions())
                                        <th>{!! trans('admin.label.actions')!!}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                @if(AdminList::showGroupBySeparator($article))
                                    <tr>
                                        <td colspan="{{AdminList::separatorColSpan()}}" class="text-start py-2 h4 "
                                            style="background-color: #c1c1c1">
                                            {{AdminList::getGroupBySeparatorValue($article)}}
                                        </td>
                                    </tr>
                                @endif
                                <tr id="row_{!! $article->id !!}" {{AdminList::getGroupBySeparatorAttribute($article)}}>
                                    @if (auth_user('admin')->action('selectable',$pageConfig))
                                        <td class="selectable-column">
                                            <x-admin.list.check-box-selectable :article="$article"/>
                                        </td>
                                    @endif
                                    @foreach(AdminList::authorizedFields() as $label)
                                        <td class="{{data_get($label,'class')}}">
                                            {!! AdminList::renderComponent($article,$label)!!}
                                        </td>
                                    @endforeach
                                    @if (AdminList::hasActions())
                                        <td class="list-actions">
                                           <x-admin.list.action :pageConfig="$pageConfig" :article="$article"></x-admin.list.action>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        @endif
        <x-admin.list.pagination :articles="$articles"/>
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
