<?php

namespace App\maguttiCms\Domain\Contact;

use App\Http\Resources\MapLocationResource;
use App\Location;
use App\maguttiCms\Domain\Website\WebsiteViewModel;
use App\Product;
use Illuminate\View\View;

class ContactViewModel extends WebsiteViewModel
{
    function show() :View
    {
        $article = $this->getPage(trans('routes.contacts'));
        $this->setSeo($article);
        $parameter = request()->get('product_id');

        $locations = MapLocationResource::collection(Location::query()->wherePub(1)->get());

        if ($parameter && !is_array($parameter)) {
            $product = Product::findOrFail($parameter);
            return view('website.contacts', ['product' => $product, 'article' => $article,'locations' => $locations]);
        }

        return view('website.contacts', ['article' => $article, 'locations' => $locations]);
    }
}