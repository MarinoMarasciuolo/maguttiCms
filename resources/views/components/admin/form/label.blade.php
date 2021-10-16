@props([
    'for',
    'label'=>'',
])
@if($label)
    <label for="{!! $for??'' !!}" {{ $attributes->merge(['class' => 'form-label']) }}>
        {!! $label !!}
    </label>
@endif




