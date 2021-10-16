<x-admin.form.label :label="$label" />
<div {{ $attributes->merge(['class' => 'bool-toggle ']) }} {{ $attributes }}>
    <span class="bool-on {{$attributes->get('value')? '' : 'd-none'}}">
        {{AdminDecorator::getBooleanOn()}}
    </span>
    <span class="bool-off {{($attributes->get('value'))? 'd-none' : ''}}">
         {{AdminDecorator::getBooleanOff()}}
    </span>
</div>



