<?php namespace App;

use App\maguttiCms\Builders\MaguttiCmsBuilder;
use App\maguttiCms\Builders\ProductBuilder;
use App\maguttiCms\Domain\Category\CategoryPresenter;
use Illuminate\Database\Eloquent\Model;
use App\maguttiCms\Translatable\GFTranslatableHelperTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Category extends Model
{
    use Translatable;
    use GFTranslatableHelperTrait;
    use CategoryPresenter;

    protected $with = ['translations'];

    protected $fillable = ['title', 'description', 'abstract', 'slug', 'sort', 'pub', 'parent_id'];
    protected array $fieldspec = [];

    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Translatable
    |--------------------------------------------------------------------------
    */
    public array $translatedAttributes = ['title', 'slug', 'description', 'seo_title', 'seo_description'];
    public array $sluggable = ['slug' => ['field' => 'title', 'updatable' => false, 'translatable' => true]];

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */

    public function media()
    {
        return $this->morphMany('App\Media', 'model');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query)
    {
        return new MaguttiCmsBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec for admin form
    |--------------------------------------------------------------------------
    */
    function getFieldSpec()
    {
        $this->fieldspec['id'] = [
            'type' => 'integer',
            'minvalue' => 0,
            'pkey' => 'y',
            'required' => true,
            'label' => trans('admin.label.id'),
            'hidden' => 1,
            'display' => 0,
        ];
        $this->fieldspec['parent_id'] = [
            'type' => 'relation',
            'model' => 'category',
            'foreign_key' => 'id',
            'label_key' => 'title',
            'required' => 0,
            'label' => trans('admin.label.category'),
            'hidden' => 0,
            'display' => 1,
        ];

        $this->fieldspec['title'] = [
            'type' => 'string',
            'pkey' => 0,
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.title'),
            'display' => 1,

        ];
        $this->fieldspec['slug'] = [
            'type' => 'string',
            'pkey' => 0,
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.slug'),
            'display' => 1,
        ];

        $this->fieldspec['description'] = [
            'type' => 'text',
            'size' => 600,
            'h' => 300,
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.description'),
            'cssClass' => 'wysiwyg',
            'display' => 1,
        ];

        $this->fieldspec['image'] = [
            'type' => 'media',
            'pkey' => 0,
            'required' => false,
            'hidden' => 0,
            'label' => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display' => 1,
        ];


        $this->fieldspec['sort'] = [
            'type' => 'integer',
            'required' => 0,
            'label' => trans('admin.label.position'),
            'hidden' => 0,
            'display' => 1,
        ];
        $this->fieldspec['pub'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.publish'),
            'display' => 1
        ];
        $this->fieldspec['seo_title'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.title'),
            'display' => 1,
        ];
        $this->fieldspec['seo_description'] = [
            'type' => 'text',
            'size' => 600,
            'h' => 300,
            'hidden' => 0,
            'label' => trans('admin.seo.description'),
            'cssClass' => 'no',
            'display' => 1,
        ];
        $this->fieldspec['seo_no_index'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.no-index'),
            'display' => 1
        ];
        return $this->fieldspec;
    }


    /*
    |--------------------------------------------------------------------------
    |  Scopes & Mutator
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {

        $query->where('pub', '=', 1)->orderBy('sort', 'ASC');
    }
}
