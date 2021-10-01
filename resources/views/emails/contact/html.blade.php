@extends('emails.master.html')
@section('content')
	<p>{{ trans('website.mail_message.contact')}}:</p>
	<ul>
		<li><b>{{ trans('email.contact.name')}}</b>: {{ $contact->full_name }}</li>
		<li><b>{{ trans('email.contact.company')}}</b>: {{ $contact->company }}</li>
		<li><b>{{ trans('email.contact.email')}}</b>: {{ $contact->email }}</li>
	</ul>
	@if ($contact->product)
		<h5>{{ trans('email.contact.product') }}</h5>
		<p>{{ $contact->product->title }}</p>
	@endif
	<h5>{{ trans('email.contact.message')}}</h5>
	<p>{!!nl2br($contact->message)!!}</p>
@endsection
