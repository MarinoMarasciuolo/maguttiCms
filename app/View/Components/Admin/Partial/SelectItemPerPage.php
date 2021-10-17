<?php

namespace App\View\Components\Admin\Partial;

use Illuminate\View\Component;

class SelectItemPerPage extends Component
{

    public array $items_per_page =[5,25,50,100,250,500];
    public int  $current_item_per_page;

    public function __construct()
    {
        $this->current_item_per_page = (request()->get('per_page'))??config('maguttiCms.admin.list.item_per_pages');
    }
    public function getItemsPerPage()
    {
        return $this->items_per_page;
    }
    public function getCurrentItemsPerPage()
    {
        return $this->current_item_per_page;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
         return view('components.admin.lists.paginate');
    }


}
