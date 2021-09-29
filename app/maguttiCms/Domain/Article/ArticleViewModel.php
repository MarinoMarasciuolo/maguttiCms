<?php

namespace App\maguttiCms\Domain\Article;


use Illuminate\View\View;

use App\maguttiCms\Domain\Website\WebsiteViewModel;


/**
 *
 */
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
        return $this->show($parent, $child);;
    }
}
