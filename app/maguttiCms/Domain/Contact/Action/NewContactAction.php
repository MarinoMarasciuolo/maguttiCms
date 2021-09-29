<?php

namespace App\maguttiCms\Domain\Contact\Action;

use App\Contact;
use App\maguttiCms\Notifications\ContactRequest;
use App\Product;
use Illuminate\Support\Facades\Notification;

/**
 *  handle new contact request
 * @property array data
 */
class NewContactAction
{
    protected array $data;


    function handle(array $data)
    {

        $this->data = $data;

        $this->data['product'] = $this->addProductIfRequest();

        $this->createContact($this->data);
        /* notify to admin */
        Notification::route('mail', config('maguttiCms.website.option.app.email'))
            ->notify(new ContactRequest($this->data));
    }

    protected function createContact(array $data)
    {
        return Contact::create($data);
    }


    protected function addProductIfRequest(): string
    {
        if (data_get($this->data, 'request_product_id')) {
            $product = Product::find(data_get($this->data, 'request_product_id'));
            return $product->title;
        }
        return "";
    }
}