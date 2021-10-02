<?php

namespace App\maguttiCms\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NavigationBaseComponent
{

    protected Collection $data;
    protected Request $request;
    protected array $config;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->config = config('maguttiCms.admin.list');
        $this->data = collect();
    }

    /**
     * return all the menu items filtered by current user permission roles
     * @param string $filter
     * @return Collection
     */
    function getMenuItems(string $filter): Collection
    {
        return collect($this->config['section'])->where($filter)->filter(
            fn($section) => auth_user('admin')->canViewSection($section)
        );
    }

    function getLabel($_code, $section): string
    {
        return (\Lang::has('admin.models.' . $_code))
            ? __('admin.models.' . $_code)
            : $section['title'];
    }

    function getAttribute($section, $attribute, $fall_back=null)
    {
        return (data_get($section, $attribute,$fall_back))
            ?: null;
    }

    function resolveUrl($section): string
    {
        $resource_url = (data_get($section, 'extra_url'))
            ?: $section['model'];

        return (Str::startsWith($resource_url, ['http', 'https']))
            ? $resource_url
            : ma_get_admin_list_url($resource_url);
    }
}