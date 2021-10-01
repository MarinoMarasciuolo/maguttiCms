@extends('emails.master.plain')
{{ $subject }}

• {{ trans('email.contact.name')}}: {{ $contact->name }}
• {{ trans('email.contact.employer')}}: {{ $contact->company }}
• {{ trans('email.contact.email')}}: {{ $contact->email }}

@if ($contact->product)
    {{ trans('email.contact.product') }}
    {{ $contact->product->title }}
@endif

{{ trans('email.contact.message')}}
{{nl2br($contact->message)}}
