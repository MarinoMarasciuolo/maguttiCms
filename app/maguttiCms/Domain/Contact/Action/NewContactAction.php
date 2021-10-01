<?php

namespace App\maguttiCms\Domain\Contact\Action;


use Illuminate\Support\Facades\Notification;

use App\Contact;
use App\maguttiCms\Notifications\ContactRequest;

/**
 * handle new contact request
 * @property array data
 */
class NewContactAction
{

    function handle(array $data)
    {
        $contact = $this->createContact($data);
        /* notify to admin */
        Notification::route('mail', config('maguttiCms.website.option.app.email'))
            ->notify(new ContactRequest($contact));
    }

    protected function createContact(array $data)
    {
        return Contact::create($data);
    }
}
