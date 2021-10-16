<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public string $for;
    public string $type;
    public string $label;
    public bool $enableError;

    /**
     * Input constructor.
     * @param $for
     * @param string $type
     * @param bool $enableError
     */
    function __construct($for, string $type='text', string $label ='',bool $enableError=true)
    {
        //
        $this->for = $for;
        $this->type = $type;
        $this->enableError = $enableError;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form.input');
    }
}
