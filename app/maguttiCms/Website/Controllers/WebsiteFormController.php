<?php namespace App\maguttiCms\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\maguttiCms\Domain\Contact\Action\NewContactAction;
use App\maguttiCms\Website\Requests\WebsiteFormRequest;
use App\maguttiCms\Notifications\ContactRequest;
use App\FaqCategory;
use App\Article;
use App\Contact;
use App\Product;

use Illuminate\Support\Facades\Notification;
use Validator;
use Input;

class WebsiteFormController extends Controller
{

    /**
     *  Contact Form  Handler
     *
     * @param WebsiteFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getContactUsForm(WebsiteFormRequest $request)
    {
        (new NewContactAction())->handle($request->validated());
        session()->flash('success', trans('website.message.contact_feedback'));
        return back();
    }

    /**
     *
     *  File upload  Handler
     *  TODO  to be improved
     *
     * @param $model
     * @param $media
     */
    private function mediaHandler($model, $media)
    {
        //$UM = new UploadManager;
        //$UM->init($media,$model);

        if (request()->hasFile($media) && request()->file($media)->isValid()) {
            $newMedia  = request()->file($media);
            $model_name = strtolower(class_basename($model));
            $destinationPath =  config('maguttiCms.admin.path.user_upload').'/'.$model_name; // upload path
            $extension 		 = $newMedia->getClientOriginalExtension(); // getting image extension
            $name 			 = basename($newMedia->getClientOriginalName(), '.'.$extension);
            $fileName 		 = Str::slug(time().'_'.$name).".".$extension; // renameing image
            $newMedia->move($destinationPath, $fileName); // uploading file to given path
            $model->$media = $model_name.'/'.$fileName;
        }
    }
}
