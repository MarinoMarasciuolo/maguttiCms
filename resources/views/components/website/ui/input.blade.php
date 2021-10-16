@props(['name' => 'generic'])
<input type="{{$type}}"
       {!! $attributes->merge(['class' =>"form-control"])!!}
       id="{{$for}}"
       name="{{$for}}"
       value="{{ old($for) }}">
@if($enableError)
    <x-website.ui.input-error-label for="{{$for}}"/>
@endif