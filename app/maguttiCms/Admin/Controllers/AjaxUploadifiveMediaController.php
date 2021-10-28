<?php

namespace App\maguttiCms\Admin\Controllers;

use App\maguttiCms\Tools\JsonResponseTrait;
use App\maguttiCms\Tools\UploadManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @property string media
 */
class AjaxUploadifiveMediaController extends AjaxController
{

    use JsonResponseTrait;
    protected string $media = 'Filedata'; // default media request file input
    /*
	|--------------------------------------------------------------------------
	|  Upload File using Ajax Method
	|--------------------------------------------------------------------------
	|  Filesystem Disk = > media
	|
	|
	*/
    public function uploadifiveMedia(Request $request)
    {
        $modelClass = 'App\\'.$request->model;

        $object = new $modelClass;
        $fieldspec = $object->getFieldSpec();

        $disk   = (isset($fieldspec[$request->key]['disk']))? $fieldspec[$request->key]['disk']: '';
        $folder = (isset($fieldspec[$request->key]['folder']))? $fieldspec[$request->key]['folder']: '';
        $rules = (isset($fieldspec[$request->key]['validation']))? $fieldspec[$request->key]['validation']: '';

        $validator = Validator::make($request->only($this->media), $this->getRules($rules) );

        if ($validator->fails()){
            $errors = $validator->errors();
            return $this->responseWithError( $errors->first() )->apiResponse();
        }

        if ($request->hasFile($this->media) &&  $request->file($this->media)->isValid()) {
            // store the data
            $upload_manager = new UploadManager;
            $file_details = $upload_manager->init($this->media, $request, $disk, $folder)->store()->getFileDetails();

            // create the media and link it to the model
            $list = $modelClass::find($request->Id);
            $this->media_category_id = $request->get('myImgType')?: 0;
            $mediaObject = $this->createMedia($file_details, $this->media_category_id);
            $list->media()->save($mediaObject);

            // response
            $data = $file_details['mediaType'];
            $this->setData($data)->responseSuccess();
            return $this->apiResponse();
        }
        return $this->responseWithError( 'Unable to upload the file or file not valid')->apiResponse();

    }

    // get media  validation rules if provided by field spec
    // or fallback to default
    protected function getRules($rules=null){
        $validation_rules = ($rules) ?: ['required','mimes:png,gif,jpg,jpeg,pdf,zip','max:2048'];
        return [$this->media => $validation_rules];
    }
}