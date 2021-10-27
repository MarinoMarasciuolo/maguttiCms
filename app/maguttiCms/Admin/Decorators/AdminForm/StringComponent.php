<?php

namespace App\maguttiCms\Admin\Decorators\AdminForm;

use Form;

class StringComponent extends InputComponentAdminForm
{
    function render($key, $value, $locale = '')
    {

        return Form::text($key, strip_tags($value,'<br>'), $this->field_properties());
    }

}