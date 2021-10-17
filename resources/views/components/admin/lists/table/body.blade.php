@aware(['config','articles'])
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
            @if (auth_user('admin')->action('selectable',$config))
                <td class="selectable-column">
                        <x-admin.lists.check-box-selectable :article="$article"/>
                </td>
            @endif
            @foreach(AdminList::authorizedFields() as $label)
                <td class="{{data_get($label,'class')}}">
                   {!! AdminList::renderComponent($article,$label)!!}
                </td>
            @endforeach
            @if (AdminList::hasActions())
                <td class="list-actions">
                    <x-admin.lists.action :config="$config" :article="$article"></x-admin.lists.action>
                </td>
            @endif
        </tr>
@endforeach
</tbody>