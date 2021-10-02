<?php

namespace App\maguttiCms\Website\Controllers;


use App\Http\Controllers\Controller;

use App\maguttiCms\Domain\Article\ArticleViewModel;


class PagesController extends Controller
{
    public function home()
    {
       return (new ArticleViewModel())->handle('home');
    }

    function pages(string $parent, string $child = '')
    {
        return (new ArticleViewModel())->handle($parent, $child);
    }
}
