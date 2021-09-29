
@if (session('success'))
    <x-ui.alert class="alert alert-color-4 alert-dismissible d-flex align-items-center" >
        {{icon('check-circle', 'fa-2x flex-shrink-0 me-2')}}
        <div>{!! session('success') !!}</div>
    </x-ui.alert>
@else
    @if ($errors->any())
        <x-ui.alert  class='alert-danger alert-dismissible d-flex align-items-center'>
            {{icon('times-circle', 'fa-2x flex-shrink-0 me-2')}}
            <div>{{__('website.message.please_fill_all_required_field')}}</div>
        </x-ui.alert>
    @endif

{{ Form::open(array('action' => '\App\maguttiCms\Website\Controllers\WebsiteFormController@getContactUsForm')) }}
<div class="row g-3">
    @if(isset($request_product_id))
        @if(isset($product))
            <div class="col-12">
				<x-website.ui.input type="hidden" for="request_product_id" placeholder="{{ __('website.name') }}"/>
                {!! __('website.message.product_request') !!}
                <mark>{{$product->title}}</mark>
            </div>
        @endif
    @endif
    <div class="col-12 col-sm-6">
        <x-website.ui.input for="name" placeholder="{{ __('website.name') }} *" required/>
    </div>
    <div class="col-12 col-sm-6">
        <x-website.ui.input for="surname" placeholder="{{ __('website.surname') }} *" required/>
    </div>
    <div class="col-12 col-sm-6">
        <x-website.ui.input type="email" for="email" placeholder="{{ __('website.email') }} *" required/>
    </div>
    <div class="col-12 col-sm-6">
        <x-website.ui.input for="company" placeholder="{{ __('website.employer') }} " />
    </div>
    <div class="col-12">
        <x-website.ui.input for="subject" placeholder="{{ __('website.subject') }} *" required/>
    </div>
    <div class="col-12">
		<x-website.ui.textarea for="message" placeholder="{{ __('website.message_email') }} *" rows="5" required/>
    </div>
    <div class="col-12 col-sm-12">
        <x-website.widgets.privacy-message/>
    </div>
    @if (data_get($site_settings,'captcha_site'))
        <div class="col-12 col-sm-6">
            <div class="pull-end">
                <div class="g-recaptcha" data-sitekey="{{data_get($site_settings,'captcha_site')}}"></div>
            </div>
        </div>
    @endif
    <div class="col-12 col-sm-6 ">
		<button type="submit" class="btn btn-primary">{{ __('website.send') }}</button>
    </div>
</div>
{{ Form::close() }}
@endif
