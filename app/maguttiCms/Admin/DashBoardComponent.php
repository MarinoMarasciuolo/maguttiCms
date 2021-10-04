<?php namespace App\maguttiCms\Admin;

use App;
use App\maguttiCms\Domain\Store\Facades\StoreHelper;
use Form;
use Illuminate\Support\Collection;

class DashBoardComponent extends NavigationBaseComponent
{

    public function init()
    {
        $this->data->push([
            'title' => 'Website',
            'url' => url()->to(''),
            'iconClass' => 'fas fa-globe',
            'target' => "_new",
            'footer_url' => url()->to(''),
            'footer_icon' => 'fas fa-external-link-alt',
            'section' => 'See website'
        ]);
    }

    function getData() : Collection
    {
        $this->init();
        foreach ($this->getMenuItems('menu.home') as $_code => $section) {
            $model = $this->resolveModelObject($section);
            $this->data->push([
                'title' => $this->getLabel($_code, $section),
                'model' => $this->getAttribute($section, 'model'),
                'url' => $this->resolveUrl($section),
                'iconClass' => 'fas fa-' . $section['icon'],
                'pills' => $this->getPillsContent($model),
                'footer_url' => (data_get($section, 'actions.create')) ? ma_get_admin_create_url($section['model']) : '',
                'target' => $this->getAttribute($section, 'target_url'),
                'total' => $this->getTotalAmount($section, $model),
                'section' => $this->getAttribute($section, 'section', 'cms')
            ]);
        }
        return $this->data;
    }

    function getTotalAmount($section, $model)
    {
        return (data_get($section, 'total')) ? StoreHelper::formatPrice($model::sum(data_get($section, 'total'))) : null;
    }

    function resolveModelObject($section)
    {
        if ($this->getAttribute($section, 'model')){
            $modelClass = 'App\\' . $section['model'];
            return  new $modelClass;
        }
        return null;
    }

    function getPillsContent($model)
    {
        return (is_object($model))
            ? $model::count()
            : null;
    }
}
