<?php

namespace App\maguttiCms\SeoTools;

use SEO;
use SEOMeta;
use Request;
use App\maguttiCms\Website\Facades\ImgHelper;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

trait MaguttiCmsSeoTrait
{
    protected string $title;
    protected string $image;
    protected $model;
    protected string $url;
    protected array $query_strings = ['page'];

    public static function bootMaguttiCmsSeoTrait()
    {
        static::created(function ($item) {

        });
    }

    public function setSeo($model): self
    {
        $this->model = $model;
        $this->image = asset('website/images/logo-share.jpg');
        if ($this->model) {
            $this->setTitle();
            $this->setDescription();
            $this->setOpenGraphImages();
            $this->setCanonical();
            $this->setNoIndex();
            $this->addAlternate();
            SEO::opengraph()->addProperty('url', Request::url());
        }

        return $this;
    }

    public function setPagination($model): void
    {
        $prev_url = preg_replace('/\?page=[1]$/', '', $model->previousPageUrl());
        $next_url = preg_replace('/\?page=[1]$/', '', $model->nextPageUrl());

        SEOMeta::setPrev($prev_url);
        SEOMeta::setNext($next_url);

        // If not first page, add page reference in title.
        if ($model->currentPage() > 1) {
            $separator = config('seotools')['meta']['defaults']['separator'];

            SEOMeta::setTitle($this->title . $separator . trans('website.pagination',
                    ['x' => $model->currentPage(), 'y' => $model->lastPage()]));
        }
    }

    public function setTitle(): void
    {
        $this->title = $this->tagHandler('title');
        if ($this->title == '') {
            $this->title = $this->tagHandler('name');
        }
        SEO::setTitle($this->title);
    }

    public function setDescription(): void
    {
        SEO::setDescription(Str::limit($this->tagHandler('description'), config('seotools.lara_setting.description')));
    }

    public function setNoIndex(): void
    {
        if (data_get($this->model, 'seo_no_index')) {
            SEO::metatags()->addMeta('robots', 'noindex');
        }
    }

    public function setCanonical(): void
    {
        $this->url = ($this->allowedQueryStrings()) ? Request::fullUrl() : Request::url();

        SEO::setCanonical($this->url);
    }

    public function setOpenGraphImages(): void
    {
        $image_conf = config('maguttiCms.image.social');
        $fieldspec = $this->model->getFieldspec();

        if (data_get($fieldspec, 'image') && optional($this->model)->image)
        {
            $folder = data_get($fieldspec, 'image.folder', null);
            $this->image = url(ImgHelper::get_cached($this->model->image, $image_conf, $folder));
        }

        $attributes = ['width' => $image_conf['w'], 'height' => $image_conf['h']];
        SEO::opengraph()->addImage($this->image, $attributes);
        SEO::twitter()->addValue('image', $this->image);
    }

    public function addOpenGraphProperty($property, $value): void
    {
        SEO::opengraph()->addProperty($property, $value);
    }

    public function addAlternate(): self
    {
        // Add alternate url only when the website has more than one language
        if (count(LaravelLocalization::getSupportedLocales()) > 1) {

            // Is page slug translation is not ignored
            if (!$this->model->ignore_slug_translation) {
                foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    $url = LaravelLocalization::getLocalizedURL($localeCode, $this->model->getPermalink($localeCode));
                    SEOMeta::addAlternateLanguage($localeCode, $url);
                }
            } else {
                foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    $url = LaravelLocalization::getLocalizedURL($localeCode);
                    SEOMeta::addAlternateLanguage($localeCode, $url);
                }
            }
        }

        return $this;
    }

    protected function tagHandler($tag)
    {
        return (optional($this->model)->{'seo_' . $tag} != '') ? $this->model->{'seo_' . $tag} : optional($this->model)->{$tag};
    }

    protected function allowedQueryStrings()
    {
        return !empty(request()->only($this->query_strings));
    }

    public function setAllowedQueryStrings($string): void
    {
        $this->query_strings[] = $string;;
    }
}
