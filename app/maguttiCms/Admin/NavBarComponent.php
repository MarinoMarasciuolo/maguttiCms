<?php namespace App\maguttiCms\Admin;


use Illuminate\Support\Collection;

class NavBarComponent extends NavigationBaseComponent
{

    function getData() : Collection
    {
        foreach ($this->getMenuItems('menu.top-bar.show') as $_code => $section) {
            $this->data->push([
                    'title' => $this->getLabel($_code,$section),
                    'url' => $this->resolveUrl($section),
                    'iconClass' => 'fas fa-' . $section['icon'],
                    'target' => $this->getAttribute($section, 'target_url'),
                    'section' => $_code,
                    'submenu' => $this->getNavBarSubItems($section)
                ]
            );
        }
        return $this->data;
    }

    function getNavBarSubItems(array $section) : Collection
    {
        $data = collect();

        if (isset($section['menu']['top-bar']['submodel'])) {
            foreach ($section['menu']['top-bar']['submodel'] as $_code => $item) {
                $data->push([
                    'title' => $this->getLabel($_code, $section),
                    'url' => ma_get_admin_list_url($_code),
                    'iconClass' => 'fas fa-' . $item['icon'],
                    'target' => data_get($section, 'target_url'),
                    'section' => $_code,
                ]);
            }
        }
        return $data;
    }
}
