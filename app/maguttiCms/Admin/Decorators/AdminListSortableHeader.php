<?php

namespace App\maguttiCms\Admin\Decorators;

/**
 * Trait AdminListOrderableHeader
 * @package App\maguttiCms\Admin\Decorators
 */
trait AdminListSortableHeader
{
    /**
     * @param $i
     * @return string
     */
    protected function getOrderableField($i)
    {
        $html = '';
        if (array_key_exists($i, $this->property['field'])) {
            $item = $this->property['field'][$i];
            if ($this->fieldIsOrderable($item)) {
                $curField = (is_array($item)) ? data_get($item, 'order_field', $item['field']) : $item;

                $html .="<span class='ps-2 table-orderable'>";

                $html .= "<a href=\"".$this->queryString($curField,'desc')."\">
                            <i class=\"fa fa-arrow-down\" aria-hidden=\"true\"></i>
                          </a>\n";
                $html .= "<a href=\"".$this->queryString($curField,'asc')."\">
                            <i class=\"fa fa-arrow-up\" aria-hidden=\"true\"></i>
                          </a>\n";
                $html .="</span>";
            }
        }

        return $html;
    }

    /**
     * @param $item
     * @return bool
     */
    protected function fieldIsOrderable($item)
    {
        return $item['orderable'] ?? false;
    }

    protected function queryString($curField,$orderType)
    {
        return request()->fullUrlWithQuery(['orderBy'=>$curField,'orderType'=>$orderType]);
    }
}