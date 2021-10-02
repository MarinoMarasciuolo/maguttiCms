<?php
namespace App\maguttiCms\Website\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Input;
use Validator;

class AjaxFormRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $segments = $this::segments();
        $model_name= end( $segments  ) ;
        return  config('maguttiCms.website.form_validation.'.$model_name);
    }
}
