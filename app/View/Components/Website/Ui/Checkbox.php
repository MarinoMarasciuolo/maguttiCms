<?php

namespace App\View\Components\Website\Ui;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public string $for;

    /**
     * Checkbox constructor.
     * @param $for
     */
    public function __construct($for)
    {
        $this->for = $for;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.website.ui.checkbox');
    }
}
