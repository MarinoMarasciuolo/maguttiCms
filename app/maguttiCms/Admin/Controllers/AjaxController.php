<?php namespace App\maguttiCms\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\maguttiCms\Tools\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Input;
use Image;
use App\maguttiCms\Tools\UploadManager;
use Illuminate\Support\Str;
use App\Media;

class AjaxController extends Controller
{
	private array $responseContainer = ['status' => 'ko', 'message' => '', 'error' => '', 'data' => ''];
    use JsonResponseTrait;
	protected $request;

	public function update(Request $request,$action, $model, $id = '' )
	{
		$this->request = $request;
		switch ($action) {
			case "updateItemField":

			if ($this->request->input('field')) {
				$field = $this->request->input('field');
				$value = $this->request->input('value');
                $locale = ($this->request->filled('locale'))?$this->request->get('locale'):null;
				$modelClass = 'App\\' . $model;
				$object = $modelClass::whereId($id)->firstOrFail();

				if($locale){
                    $attribute = substr($field, 0, -3);
                    $object->translateOrNew($locale)->$attribute = $value;
                }
				else {
                    $object->$field = $value;
                }

                $object->save();
                return $this->setData($object)->responseWithSuccess('Data has been updated');
			}
        }
        return $this->responseWithError( 'Data not found')->apiResponse();
	}

	public function delete($model, $id = '')
	{
		$modelClass = 'App\\' . ucFirst($model);
		$object = $modelClass::whereId($id)->first();
		if (is_object($object)) {
			$object->delete();
			return $this->responseWithSuccess('Data has been deleted');
		}
        return $this->responseWithError( 'Data not found')->apiResponse();
	}

	public function responseHandler()
	{
		return response()->json($this->responseContainer);
	}

	/**
	* This method is used to upload filemanager image or docs
	*/
	public function uploadFileManager(Request $request)
	{
		$media = 'Filedata';

		if (request()->hasFile($media) && request()->file($media)->isValid()) {
			$UM = new UploadManager;
			$fileData = $UM->init($media, $request)->store()->getFileDetails();

			$c = new Media;
			$c->title = $fileData['fullName'];
			$c->file_name = $fileData['fullName'];
			$c->size = $fileData['size'];
			$c->collection_name = $fileData['mediaType'];
			$c->media_category_id = 0;
			$c->file_ext = $fileData['extension'];
			$c->save();

			$this->responseContainer['status'] = 'ok';
			$this->responseContainer['id'] = $c->id;
			$this->responseContainer['data'] = $fileData['mediaType'];

			return $this->responseHandler();
		}
	}





	/**
	* Edited: GF_ma check if the field is translatable.
	*
	* @param $model: The model.
	* @param $key: The field to look for.
	*
	* @return bool: True if translatable, false otherwise.
	*/
	protected function isTranslatableField($model, $key)
	{
		return (property_exists($model, 'translatedAttributes') && in_array($key, $model->translatedAttributes));
	}
}
