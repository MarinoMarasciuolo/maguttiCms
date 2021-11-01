<?php

namespace App\maguttiCms\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\maguttiCms\Tools\JsonApiResponseTrait;
use App\maguttiCms\Tools\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Input;
use Image;
use App\maguttiCms\Tools\UploadManager;
use Illuminate\Support\Str;
use App\Media;

class AjaxBaseMediaController extends Controller
{

    use JsonResponseTrait;

    public function createMedia($data, $media_category_id)
    {
        $media = new Media;
        $media->title = $data['fullName'];
        $media->file_name = $data['fullName'];
        $media->size = $data['size'];
        $media->collection_name = $data['mediaType'];
        $media->disk = $data['disk'];
        $media->media_category_id = $media_category_id;
        $media->file_ext = $data['extension'];
        return $media;
    }

    /**
     * Edited: GF_ma check if the field is translatable.
     *
     * @param $model The model.
     * @param $key The field to look for.
     *
     * @return bool: True if translatable, false otherwise.
     */
    protected function isTranslatableField($model, $key)
    {
        return (property_exists($model, 'translatedAttributes') && in_array($key, $model->translatedAttributes));
    }

    /**
     * @param $request
     * @return array
     */
    protected function uploadHandler($request)
    {

        $disk   = data_get($this->fieldspec,$request->key.'.disk');
        $folder = data_get($this->fieldspec,$request->key.'.folder');

        // store the data
        return (new UploadManager)->init($this->media, $request, $disk, $folder)->store()->getFileDetails();

    }


    // get media  validation rules if provided by field spec
    // or fallback to default

    /**
     * @param $key
     * @return \string[][]
     */
    protected function getRules($key)
    {
        $rules = data_get($this->fieldspec,$key.'.folder');
        $validation_rules = ($rules) ?: ['required', 'mimes:png,gif,jpg,jpeg,pdf,zip', 'max:2048'];
        return [$this->media => $validation_rules];
    }


    /**
     * @param $request
     * @param $media
     * @return bool|\Illuminate\Http\JsonResponse
     */
    protected function validateMedia($request,$media)
    {
        $validator = Validator::make($request->only($media), $this->getRules($request->key));

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->responseWithError($errors->first())->apiResponse();
        }
        return true;
    }

}
