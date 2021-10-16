<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class InputBoolean extends Input
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form.input-boolean');
    }
}
