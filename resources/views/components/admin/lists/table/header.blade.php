@aware(['config'])
<thead>
<tr>
    {{ AdminList::initList($config)->getListHeader() }}
    @if (AdminList::hasActions())
        <th>{!! __('admin.label.actions')!!}</th>
    @endif
</tr>
</thead>