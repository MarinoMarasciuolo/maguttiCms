<?php

namespace App\maguttiCms\Domain\Article;


use App\Http\Resources\MapLocationResource;
use App\Location;
use App\Product;
use App\maguttiCms\Domain\Website\WebsiteViewModel;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Mixed_;

class ArticleViewModel extends WebsiteViewModel
{

    function index() : View
    {
        $article = $this->getPage('home');
        $this->setSeo($article);
        $template = $this->handleTemplate($article);
        return view($template, compact('article'));
    }

    function intro() :View
    {
        $article = $this->getPage('home');
        $this->setSeo($article);
        return view('website.home', compact('article'));
    }

    function show( string $parent, string $child = '')
    {
        $article = (!$child) ? $this->getParentPage($parent, app()->getLocale()) : $this->getSubPage($parent, $child);
        if ($this->validatePage($article)) {
            $this->setSeo($article);
            $template = $this->handleTemplate($article);
            return view($template, compact('article'));
        }
        return $this->handleMissingPage();
    }


    function contacts() :View
    {
        $article = $this->getPage(trans('routes.contacts'));
        $this->setSeo($article);
        $parameter = request()->get('product_id');

        $locations = MapLocationResource::collection(Location::query()->wherePub(1)->get());

        if ($parameter && !is_array($parameter)) {
            $product = Product::findOrFail($parameter);
            return view('website.contacts', ['request_product_id' => $parameter, 'product' => $product, 'article' => $article,'locations' => $locations]);
        }

        return view('website.contacts', ['request_product_id' => 0, 'article' => $article, 'locations' => $locations]);
    }


    protected function getParentPage($parent)
    {

        $page = $this->getPage($parent, app()->getLocale());
        // Return false if page has parented because this method is used only for parent page
        return ($page && $page->parent_id != 0) ? false : $page;

    }

    public function getSubPage(string $parent, string $child)
    {
        $parent = $this->getPage($parent);
        $child = $this->getPage($child);

        // If $parent or $child doesn't exists
        if (!$parent || !$child) {
            return false;
        }

        // If $parent and $child doesn't match
        if ($parent->id != $child->parent_id) {
            return false;
        }

        // Return $child data
        return $child;
    }

    function handleTemplate($article) : string
    {
        // Get website default locale
        $fallback_locale = \Config::get('app.fallback_locale');
        $template = ($article->template_id) ? $article->template->value : $article->{'slug:' . $fallback_locale};
        return (view()->exists('website.' . $template)) ? 'website.' . $template : 'website.normal';
    }

    /**
     * @param $article
     * @return bool
     */
    function validatePage($article): bool
    {
        return $article && $article->slug != 'home' && $article->pub == 1;
    }

    function handle($parent, $child = '')
    {
        if ($parent == 'home') return $this->index();
        if ($parent == 'intro') return $this->intro();
        if ($parent == 'contacts') return $this->contacts();
        return $this->show($parent, $child);;
    }
}
