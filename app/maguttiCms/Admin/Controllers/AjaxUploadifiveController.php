<?php

namespace App\maguttiCms\Admin\Controllers;

use Illuminate\Http\Request;

use App\maguttiCms\Tools\JsonResponseTrait;

/**
 * @property string media
 */
class AjaxUploadifiveController extends AjaxBaseMediaController
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
    protected array $fieldspec;

    public function handle(Request $request)
    {
        $modelClass = 'App\\' . $request->model;
        $this->fieldspec = (new $modelClass)->getFieldSpec();

        //True if the file has been uploaded with HTTP and no error occurred
        if (!$request->file($this->media)->isValid()) {
            return $this->responseWithError('Unable to upload the file or file not valid')->apiResponse();
        }

        $response = $this->validateMedia($request, $this->media);
        if ($response !== true) return $response;

        $file_details = $this->uploadHandler($request);
        return $this->setData($file_details)->responseWithSuccess();;

    }

}