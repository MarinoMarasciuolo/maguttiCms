<?php

namespace App\maguttiCms\Admin\Controllers;


use App\maguttiCms\Tools\UploadManager;
use Illuminate\Http\Request;
use App\maguttiCms\Tools\JsonResponseTrait;
use Illuminate\Support\Str;


/**
 * @property string media
 */
class AjaxImageCropperController extends AjaxBaseMediaController
{

    use JsonResponseTrait;


    /*
	|--------------------------------------------------------------------------
	|  Handle The Image Crop File
	|--------------------------------------------------------------------------
	|  Filesystem Disk = > media
	|
	|
	*/

    public function handle(Request $request)
    {
        $modelClass = 'App\\' . $request->model;

        if (!$request->image) {
            return $this->responseWithError( 'Unable to upload the file or file not valid')->apiResponse();
        }

        $config = config('maguttiCms.admin.list.section.' . Str::plural(strtolower($request->model)));
        $config = collect($config['mediaCropper']);


        // store the data
        $file_details = (new UploadManager)
                            ->init('', $request, 'media', 'images')
                            ->storeData($request->image, $request->filename, $config);

        // create the media and link it to the model
        $list = $modelClass::find($request->id);
        $media_category_id = $request->get('myImgType') ?: 0;
        $media = $this->createMedia($file_details, $media_category_id);
        $list->media()->save($media);

        // response
        $data = 'images';
        return $this->setData($data)->responseWithSuccess();
    }

}