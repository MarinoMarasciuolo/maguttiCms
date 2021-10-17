<?php


namespace App\maguttiCms\Admin\Decorators;



use Illuminate\Support\Str;



trait AdminListExtraComponentTrait
{
    protected string $_ADMIN_LIST_EXTRA_COMPONENT_DEFAULT ="App\View\Components\Admin\Lists\\";
    protected string $_ADMIN_LIST_EXTRA_COMPONENT_DEFAULT_PATH ="admin.lists.";


    function validatedIfExtraHeaderComponentExist($itemProperty)
    {
        if($this->hasCustomComponent($itemProperty)){
            return true;
        }
        if ($this->componentExtraHeaderComponentClassExist($itemProperty['model'])) {
            return true;
        }
        return false;

    }

    private function hasCustomComponent($itemProperty){
       return data_get($itemProperty,'list_custom_header');
    }

    private function componentExtraHeaderComponentClassExist($type): bool
    {
        return class_exists($this->resolveExtraHeaderComponentClassClassNamespace($type));
    }
    function resolveExtraHeaderComponentClassClassNamespace($type): string
    {
        return $this->_ADMIN_LIST_EXTRA_COMPONENT_DEFAULT . ucfirst(Str::camel($type)) . "ExtraFeatures";
    }

    function getExtraHeaderComponentName($itemProperty): string
    {
        if($this->hasCustomComponent($itemProperty)){
            return data_get($itemProperty,'list_custom_header');
        }
        return $this->_ADMIN_LIST_EXTRA_COMPONENT_DEFAULT_PATH . Str::lower($itemProperty['model']) . "-extra-features";
    }

}