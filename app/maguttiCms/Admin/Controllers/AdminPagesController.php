<?php

namespace App\maguttiCms\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Validator;
use Auth;


use App\maguttiCms\Admin\AdminFormFieldsProcessor as AdminFormFieldsProcessor;
use App\maguttiCms\Admin\Helpers\ModelReplicatorTrait;
use App\maguttiCms\Admin\Requests\AdminFormRequest;
use App\maguttiCms\Searchable\SearchableTrait;
use App\maguttiCms\Sluggable\SluggableTrait;

/**
 * Class AdminPagesController
 * @package App\maguttiCms\Admin\Controllers
 */
class AdminPagesController extends Controller
{
    use SluggableTrait;
    use SearchableTrait;
    use ModelReplicatorTrait;

    protected $model;
    protected $models;
    protected $modelClass;
    protected $curObject;
    protected $request;
    protected $config;
    protected $fieldSpecs;
    protected $id;


    /**
     * @param $model
     */
    public function init($model)
    {
        $this->model = $model;
        $this->config = config('maguttiCms.admin.list.section.' . $this->model);
        $this->models = strtolower(Str::plural($this->config['model']));
        $this->modelClass = 'App\\' . $this->config['model'];
    }

    /**
     * ADMIN HOME PAGE
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('admin.home');
    }

    /**
     * Show the index list of a model.
     * @param Request $request
     * @param $model
     * @param string $sub
     * @return View
     */
    public function lista(Request $request, $model, $sub = ''): View
    {
        $this->request = $request;
        $this->init($model);
        $models = new $this->modelClass;
        $objBuilder = $models::query();

        $this->setCurModel($models);
        $this->addSelect($objBuilder);
        $this->selectSub($objBuilder);
        $this->joinable($objBuilder);
        $this->whereFilter($objBuilder);
        $this->searchFilter($objBuilder);
        $this->orderFilter($objBuilder);
        $this->withRelation($objBuilder);

        if ($this->isTranslatableField($this->sort)) {
            $objBuilder->select($this->model->getTable() . '.*');
        }

        if ($this->modelClass == 'App\AdminUser') {
            if (!cmsUserHasRole('su')) {
                $objBuilder->whereHas('roles', function ($query) {
                    $query->where('name', '!=', 'su');
                });
            }
        }
        $item_per_page =(request('per_page'))??config('maguttiCms.admin.list.item_per_pages');
        $articles = $objBuilder->paginate($item_per_page);
        $articles->appends($request->all())->links(); // paginazione con parametri di ricerca
        $fieldspec = $models->getFieldspec();
        $admin_can_edit = cmsUserHasRole(['su', 'admin']);
        return view('admin.list', [
            'articles' => $articles,
            'pageConfig' => collect($this->config),
            'fieldspec' => $fieldspec,
            'model' => $this->models,
            'admin_can_edit' => $admin_can_edit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $model
     *
     *
     */
    public function create($model)
    {
        $this->init($model);
        $article = new $this->modelClass;
        $locales =collect(config('app.locales'))->toJson();
        $pageTemplate = data_get($this->config,'editTemplate','admin.edit');
        return view($pageTemplate, ['article' => $article, 'pageConfig' => collect($this->config),'locales'=>$locales]);
    }

    /**
     * Show the form for editing
     * the specified resource.
     * @param $model
     * @param $id
     */

    public function edit($model, $id)
    {
        $this->id = $id;
        $this->init($model);
        $article = $this->modelClass::whereId($this->id)->firstOrFail();
        /*TODO da  cancellare ?? */
        if ($this->modelClass == 'App\AdminUser') {
            if (!cmsUserHasRole('su') && $article->hasRole('su')) {
                return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@lista', $this->model));
            }
        }
        $locales =collect(config('app.locales'))->toJson();
        $pageTemplate = data_get($this->config,'editTemplate','admin.edit');
        return view($pageTemplate, ['article' => $article, 'pageConfig' => collect($this->config),'locales'=>$locales]);
    }

    /**
     * View model resource
     *
     * @param $model
     * @param $id
     * @return View
     */
    public function view($model, $id) : View
    {
        $this->id = $id;
        $this->init($model);
        $article = $this->modelClass::whereId($this->id)->firstOrFail();
        $pageTemplate = data_get($this->config,'viewTemplate','admin.view');
        return view($pageTemplate, ['article' => $article, 'pageConfig' => collect($this->config)]);
    }

    /**
     *
     * Show the form for editing
     * in modal window
     *
     * @param $model
     * @param $id
     *
     *
     */
    public function editmodal($model, $id)
    {
        $this->id = $id;
        $this->init($model);
        $article = $this->modelClass::whereId($this->id)->firstOrFail();
        if ($this->modelClass == 'App\AdminUser') {
            if (!cmsUserHasRole('su') && $article->hasRole('su')) {
                return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@lista', $this->model));
            }
        }
        return view('admin.editmodal', ['article' => $article, 'pageConfig' => collect($this->config)]);
    }

    /**
     * Store a newly created  resource in storage.
     *
     * @param string $section
     * @param AdminFormRequest $request
     * @return RedirectResponse
     */
    public function store(string $section, AdminFormRequest $request): RedirectResponse
    {
        $this->init($section);
        $model = new  $this->modelClass;
        $article = new $model;

        (new AdminFormFieldsProcessor($request))->requestFieldHandler($article);
        session()->flash('success', 'The item <strong>' . $article->title . '</strong> has been created!');

        return redirect()->route('admin_edit',['section' =>$this->models, 'id' => $article->id ]);
    }


    /**
     * Update resource in storage
     *
     * @param $section
     * @param int $id
     * @param AdminFormRequest $request
     * @return RedirectResponse
     */
    public function update($section, int $id, AdminFormRequest $request): RedirectResponse
    {
        $this->init($section);
        $article = $this->modelClass::whereId($id)->firstOrFail();
        (new AdminFormFieldsProcessor($request))->requestFieldHandler($article);
        return redirect()->route('admin_edit',['section' => $this->models, 'id' => $article->id ]);
    }

    /**
     * Update resource in storage
     * in modal window
     *
     * @param $model
     * @param $id
     * @param AdminFormRequest $request
     */
    public function updatemodal($model, $id, AdminFormRequest $request)
    {
        $this->init($model);
        $article = $this->modelClass::whereId($id)->firstOrFail();
        (new AdminFormFieldsProcessor($request))->requestFieldHandler($article);
        echo json_encode(array('status' => $this->config['model'] . ' Has been update'));
    }


     /**
     *
     * Simple model duplicate function
     *
     * @param $section
     * @param $id
     *
     */

    public function duplicate($section, $id)
    {
        $this->init($section);
        $article = $this->duplicateModel($id);
        return redirect(route('admin_edit',['section' =>$this->models, 'id' => $article->id ]));
    }



    /**
     * Delete resource in storage
     *
     * @param $model
     * @param $id
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($model, $id)
    {
        $this->init($model);
        $article = $this->modelClass::whereId($id)->firstOrFail();
        $article->delete();
        session()->flash('success', 'The items ' . $article->title . ' has been deleted!');
        return redirect(action('\App\maguttiCms\Admin\Controllers\AdminPagesController@lista', $this->models));
    }


    /**
     *  view / download file
     *
     * @param $model
     * @param $id
     * @param $key
     * @return \Illuminate\Http\Response
     */
    public function file_view($model, $id, $key)
    {
        $this->id = $id;
        $this->init($model);
        $article = $this->modelClass::whereId($this->id)->firstOrFail();

        if ($article) {
            $file = $this->get_file($article, $key);
            if ($file['file']) {
                return response()->make($file['file'], 200, [
                    'Content-Type' => $file['mime'],
                    'Content-Disposition' => 'inline; filename="' . $article->$key . '"'
                ]);
            }
        }
    }

    /*
     * get file from storage
     */
    public function get_file($object, $key)
    {
        $fields = $object->getFieldSpec();

        $disk = (isset($fields[$key]['disk'])) ? $fields[$key]['disk'] : 'media';
        $folder = (isset($fields[$key]['folder'])) ? $fields[$key]['folder'] : 'docs';

        $storage = \Storage::disk($disk);

        if ($storage->exists($folder . '/' . $object->$key)) {
            return [
                'file' => $storage->get($folder . '/' . $object->$key),
                'mime' => $storage->mimeType($folder . '/' . $object->$key)
            ];
        }
        return false;

    }
}
