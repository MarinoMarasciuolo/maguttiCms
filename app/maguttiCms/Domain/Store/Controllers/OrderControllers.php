<?php


namespace App\maguttiCms\Domain\Store\Controllers;


use App\Article;
use App\Http\Controllers\Controller;
use App\maguttiCms\Domain\Store\Facades\StoreHelper;
use App\Order;
use \App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;

class OrderControllers extends Controller
{
    use MaguttiCmsSeoTrait;

    function index()
    {
        $article = $this->getPage('dashboard');
        return view('magutti_store::order.index', compact('article'));
    }

    public function show(Order $order)
    {
        $article = $this->getPage('dashboard');
        $this->setSeo( $order );
        return view('magutti_store::order.detail', compact('article', 'order'));
    }

    function getPage($slug)
    {
        return Article::findBySlug($slug, app()->getLocale());
    }
}
