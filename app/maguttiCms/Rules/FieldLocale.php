<?php

namespace App\maguttiCms\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @property string current_locale
 */
class FieldLocale implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->current_locale = app()->getLocale();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        //
        foreach (config('app.locales') as $locale => $code) {
           // skip the current locale
           if($locale!=$this->current_locale){
                $field_locale =$attribute.'_'.$locale;
                if(request()->get($field_locale)=='')return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return 'All the :attribute fields are required';
    }
}
