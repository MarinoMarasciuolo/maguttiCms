<x-admin.form.label :for="$for" :label="$label" />
<input
    id="{!! $for !!}"
    {{ $attributes->merge(['class' => 'form-control']) }}
    name="{!! $for !!}"
    {{ $attributes }}
    type="{{$type??'text'}}"
/>



