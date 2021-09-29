<?php

namespace App\maguttiCms\Domain\Website;


use App\Article;
use \App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;

/**
 * Class WebsiteViewModel
 * @package App\maguttiCms\Domain\Website
 */
abstract class WebsiteViewModel
{

    use MaguttiCmsSeoTrait;
    protected $currentPage;

    function __construct(string $page_slug = '')
    {

        if ($page_slug != '') $this->setCurrentPage($page_slug);
    }

    function getPage(string $slug)
    {
        return Article::findBySlug($slug, app()->getLocale());
    }

    function handleMissingPage()
    {

        return redirect('/');
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param string $page_slug
     */
    public function setCurrentPage(string $page_slug): void
    {
        $this->currentPage = $this->getPage($page_slug);
    }

    function handle(string $slug)
    {
        return ($slug == '') ? $this->index() : $this->show($slug);
    }
}
