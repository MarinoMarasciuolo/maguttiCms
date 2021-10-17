<div>
    <select  id="per_page" name="per_page" {{ $attributes->merge(['class' => 'form-select']) }}  aria-label="list items per page">
        @foreach($getItemsPerPage() as $items_per_page)
        <option value="{{ $items_per_page }}" {{($items_per_page==$getCurrentItemsPerPage())?'selected':''}}>
            {{ __('admin.label.items_per_page',['items'=>$items_per_page]) }}
        </option>
        @endforeach
    </select>
</div>



