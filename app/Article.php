<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\maguttiCms\Translatable\GFTranslatableHelperTrait;

use App\maguttiCms\Domain\Media\Mediable;
use App\maguttiCms\Domain\Block\Blockable;
use App\maguttiCms\Builders\ArticleBuilder;
use \App\maguttiCms\Domain\Article\ArticlePresenter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class Article
 * @package App
 */
class Article extends Model
{
    use Translatable;
    use GFTranslatableHelperTrait;
    use Blockable;
    use Mediable;
    use ArticlePresenter;

    protected $with = ['translations'];
    public array $cloneable_relations= ['translations'];
    public array $clone_exempt_attributes = ['slug'];

    protected $fillable = [
        'title', 'subtitle', 'abstract', 'description',
        'slug', 'sort', 'pub', 'top_menu', 'footer_menu', 'parent_id',
        'link', 'template_id', 'ignore_slug_translation',
        'video', 'doc'
    ];

    protected array $fieldspec = [];


    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Translatable
    |--------------------------------------------------------------------------
    */
    public array $translatedAttributes = [
        'menu_title', 'title', 'subtitle', 'slug',
        'description', 'abstract',
        'seo_title', 'seo_description', 'seo_no_index'
    ];

    public array $sluggable = ['slug' => ['field' => 'title', 'updatable' => false, 'translatable' => true]];


    /*
    |--------------------------------------------------------------------------
    |  RELATIONS
    |--------------------------------------------------------------------------
    */
    public function template(): BelongsTo
    {
        return $this->belongsTo('App\Domain', 'template_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo('App\Article', 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany('App\Article', 'parent_id', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query): ArticleBuilder
    {
        return new ArticleBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec for admin form
    |--------------------------------------------------------------------------
    */
    function getFieldSpec(): array
    {
        $this->fieldspec['id'] = [
            'type' => 'integer',
            'minvalue' => 0,
            'pkey' => 1,
            'required' => 1,
            'label' => trans('admin.label.id'),
            'hidden' => 1,
            'display' => 0,
        ];
        $this->fieldspec['parent_id'] = [
            'type' => 'relation_tree',
            'tree_field' => 'parent_id',
            'order_field' => 'sort',
            'model' => 'article',
            'foreign_key' => 'id',
            'label_key' => 'title',
            'required' => 0,
            'label' => trans('admin.label.parent'),
            'hidden' => 0,
            'display' => 1,
        ];
        $this->fieldspec['template_id'] = [
            'type' => 'relation',
            'model' => 'Domain',
            'filter' => ['domain' => 'template'],
            //'whereRaw' => 'domain in ("template","block_template")',
            'foreign_key' => 'id',
            'label_key' => 'title',
            'required' => 0,
            'label' => trans('admin.label.template'),
            'hidden' => 0,
            'display' => 1,
        ];
        $this->fieldspec['menu_title'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.menu_title'),
            'display' => 1,
        ];
        $this->fieldspec['title'] = [
            'type' => 'string',
            'required' => 1,
            // uncomment if you want validate all title fields
            //'validation'=>['required','field_locale'],
            'hidden' => 0,
            'label' => trans('admin.label.title'),
            'display' => 1,
        ];
        $this->fieldspec['subtitle'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.subtitle'),
            'display' => 1,
            'cssClassElement' => 'col-md-4 col-lg-4',
            'row-item' => 'start'
        ];

        $this->fieldspec['slug'] = [
            'type' => 'vue_component',
            'component-name' => 'clearable-input-component',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.slug'),
            'display' => 1,
            'cssClassElement' => 'col-md-4 col-lg-4',
            'row-item' => 'stop'
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
        $this->fieldspec['abstract'] = [
            'type' => 'text',
            'size' => 600,
            'h' => 100,
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.additional'),
            'cssClass' => 'wysiwyg',
            'display' => 1,
        ];
        $this->fieldspec['link'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.ext_url'),
            'display' => 1,
        ];
        $this->fieldspec['image'] = [
            'type' => 'media',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display' => 1,
            'disk' => 'media',

        ];
        $this->fieldspec['doc'] = [
            'type' => 'media',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.doc'),
            'lang' => 0,
            'mediaType' => 'Doc',
            'display' => 1,
            'uploadifive' => 1,
            'validation'=>['mimes:pdf,zip,doc','max:2048'],
            'accept' => '.pdf'
        ];
        $this->fieldspec['video'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => "YouTube video code",
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
            'display' => 1,
            'cssClassElement' => 'col-md-2 col-lg-2',
            'row-item' => 'start'
        ];
        $this->fieldspec['top_menu'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.top_menu'),
            'display' => 1,
            'cssClassElement' => 'col-md-2 col-lg-2',
            'row-item' => 'column'
        ];
        $this->fieldspec['footer_menu'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.footer_menu'),
            'display' => 1,
            'cssClassElement' => 'col-md-2 col-lg-2',
            'row-item' => 'stop',
        ];

        $this->fieldspec['ignore_slug_translation'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.slug_ignore'),
            'display' => 1,
            'cssClassElement' => 'col-md-2 col-lg-2',

        ];
        $this->fieldspec['seo_title'] = [
            'type' => 'seo_string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.title'),
            'display' => 1,
            'max' => 65
        ];
        $this->fieldspec['seo_description'] = [
            'type' => 'seo_text',
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
}
