<?php namespace App\maguttiCms\Admin\Controllers;

use App\Http\Controllers\Controller;
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

                $this->responseContainer['status'] = 'ok';
				$this->responseContainer['message'] = 'Data has been updated';
				$this->responseContainer['data'] = $object;
			}
			break;
		}
		return $this->responseHandler();
	}

	public function delete($model, $id = '')
	{
		$modelClass = 'App\\' . ucFirst($model);
		$object = $modelClass::whereId($id)->first();
		if (is_object($object)) {
			$object->delete();
			$this->responseContainer['status'] = 'ok';
			$this->responseContainer['message'] = 'Data has been deleted';
		} else {
			$this->responseContainer['error'] = 'Data not found';
		}
		return $this->responseHandler();
	}


	/*
	|--------------------------------------------------------------------------
	|  Upload File using Ajax Method
	|--------------------------------------------------------------------------
	|  Filesystem Disk = > media
	|
	|
	*/
	public function uploadifiveSingle(Request $request)
	{
		$modelClass = 'App\\' . $request->model;
		$object = new $modelClass;
		$fieldspec = $object->getFieldSpec();
		$disk = (isset($fieldspec[$request->key]['disk']))? $fieldspec[$request->key]['disk']: '';
		$folder = (isset($fieldspec[$request->key]['folder']))? $fieldspec[$request->key]['folder']: '';

		$media = 'Filedata';
		if (request()->hasFile($media) && request()->file($media)->isValid()) {
			$UM              = new UploadManager;
			$fileData        = $UM->init($media, $request, $disk, $folder)->store()->getFileDetails();

			// $disk            = "media";
			// $destinationPath = $disk.'/' .$fileData['mediaType']; // upload path folder
			// if (is_image($fileData['mediaType']) == 'image') {
			//     //$img = Image::make($newMedia->getRealPath());
			//     $img = Image::make(public_path( $destinationPath . '/' . $fileData['fullName'] ))->widen(1600);
			//     // save file as png with medium quality
			//     $img->save(public_path($destinationPath . '/' . $fileData['fullName'], 60));
			// }

			$this->responseContainer['status'] = 'ok';
			$this->responseContainer['data']   = $fileData['mediaType'];
			$this->responseContainer['filename'] = $fileData['fullName'];
			return $this->responseHandler();
		}
	}

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
        $disk = (isset($fieldspec[$request->key]['disk']))? $fieldspec[$request->key]['disk']: '';
        $folder = (isset($fieldspec[$request->key]['folder']))? $fieldspec[$request->key]['folder']: '';

        $media = 'Filedata';

        if ($request->hasFile($media) && $request->file($media)->isValid()) {
            // store the data
            $upload_manager = new UploadManager;
            $file_details = $upload_manager->init($media, $request, $disk, $folder)->store()->getFileDetails();

            // create the media and link it to the model
            $list = $modelClass::find($request->Id);
            $media_category_id = $request->get('myImgType')?: 0;
            $media = $this->createMedia($file_details, $media_category_id);
            $list->media()->save($media);

            // response
            $this->responseContainer['status'] = 'ok';
            $this->responseContainer['data'] = $file_details['mediaType'];
            return $this->responseHandler();
        } else {
            $this->responseContainer['error'] = 'Unable to upload the file or file not valid.';
        }
        return $this->responseHandler();
    }

	public function cropperMedia(Request $request)
	{
		$modelClass = 'App\\' . $request->model;
		$object = new $modelClass;

		$config = config('maguttiCms.admin.list.section.'.Str::plural(strtolower($request->model)));
		$config = collect($config['mediaCropper']);

		$data = $request->image;

		if (!$data) {
			$this->responseContainer['message'] = 'Invalid data';
			return $this->responseHandler();
		}

		// store the data
		$upload_manager = new UploadManager;
		$file_details = $upload_manager->init('', $request, 'media', 'images')->storeData($data, $request->filename, $config);

		// create the media and link it to the model
		$list = $modelClass::find($request->id);
		$media_category_id = $request->get('myImgType')?: 0;
		$media = $this->createMedia($file_details, $media_category_id);
		$list->media()->save($media);

		// response
		$this->responseContainer['status'] = 'ok';
		$this->responseContainer['data'] = 'images';
		return $this->responseHandler();
	}
    /*
    |--------------------------------------------------------------------------
    |  Upload Image  From TinyMCE
    |--------------------------------------------------------------------------
    |  Filesystem Disk = > media
    |
    |
    */
    public function uploadMediaTinyMCE(Request $request)
    {
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return response('Server error', 500);
        }

        $extension = $request->file('file')->extension();
        $file_path = $request->file('file')->storeAs('tinymce', Str::random(20).'.'.$extension, 'images');
        $storage = Storage::disk('images');
        return response()->json([
            'location' => $storage->url($file_path)
        ]);
    }

	public function createMedia($data, $media_category_id)
	{
		$media = new Media;
		$media->title               = $data['fullName'];
		$media->file_name           = $data['fullName'];
		$media->size                = $data['size'];
		$media->collection_name     = $data['mediaType'];
		$media->disk                = $data['disk'];
		$media->media_category_id   = $media_category_id;
		$media->file_ext            = $data['extension'];

		return $media;
	}

	public function updateMediaList($mediaType, $model, $id = '')
	{
		$modelClass = 'App\\' . ucfirst($model);
		$object = $modelClass::whereId($id)->firstOrFail();
		if ($mediaType == 'images') {
			return view('admin.helper.images_list_gallery', ['article' => $object]);
		} else {
			return view('admin.helper.docs_list', ['article' => $object]);
		}
	}

	public function updateModelMediaList($modelFilter)
	{
		$object = Media::orderBy('id', 'DESC')->get();
		return view('admin.helper.modal_media_gallery', ['medias' => $object]);
	}

	public function updateMediaSortList(Request $request)
	{
		$i = 1;

        $input = $request->all();
		foreach ($input as $key => $items) {
			$dataObject = explode('_', $key);
			foreach ($items as $id) {
				$modelClass = 'App\\' . ucfirst($dataObject[1]);
				$object = $modelClass::whereId($id)->firstOrFail();
				$object->sort = $i * 10;
				$object->save();
				$i++;
			};
		};
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
	* This method is used to fetch filemanager media list
	*/
	public function getFileManagerList($id='')
	{
		$object = (new Media)->when($id, function ($query) use ($id) {
			$query-> orderByRaw('IF(FIELD(id,'.$id.')=0,1,0)');
		})->orderBy('id', 'DESC')->get();
		return view('admin.helper.filemanager-list', ['medias' => $object]);
	}

	/**
	* This method is used to fetch edit view
	*/
	public function editFileManager($id)
	{
		$media = Media::whereId($id)->firstOrFail();
		return view('admin.helper.filemanager-edit', ['media' => $media]);
	}

	/**
	* This method is used to save the edit data
	*/
	public function updateFileManager(Request $request,$id )
	{
		$article = Media::find($id);

		$this->request = $request;

		foreach ($article->getFillable() as $a) {
			$article->$a = $this->request->get($a);
		}

		$article->save();

		// translatable
		if (isset($article->translatedAttributes) && count($article->translatedAttributes) > 0) {
			foreach (config('app.locales') as $locale => $value) {
				foreach ($article->translatedAttributes as $attribute) {
					// se è un attributo sluggabile;
					if (isset($article->sluggable) && $this->attributeIsSluggable($attribute, $article->sluggable)) {
						$attribute_to_slug = (config('app.locale') != $locale) ? $attribute.'_' . $locale:$attribute;
						$string_value      = $this->setSlugAttributes($a)
						->sluggyTranslatable($article, $this->request->get($attribute_to_slug), $locale);

						$article->translateOrNew($locale)->$attribute = $string_value;
					} else {
						if (config('app.locale') != $locale) {
							$article->translateOrNew($locale)->$attribute = $this->request->get($attribute . '_' . $locale);
						} else {
							$article->translateOrNew($locale)->$attribute = $this->request->get($attribute);
						}
					}
				}
				$article->save();
			}
		}

		$this->responseContainer['status'] = 'ok';
		$this->responseContainer['message'] = 'Data has been updated';

		return $this->responseHandler();
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
