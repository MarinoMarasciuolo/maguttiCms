<?php
return [
    /**
     * Generic values are filled when when neither package was able to guess out the value.
     *
     * @var array
     */
    'item_per_pages' => 25,
    'section' => [

        'articles' => [
            'model' => 'Article',
            'title' => 'Pages',
            'icon' => 'newspaper',
            'section' =>'cms',
            'field' => ['id',
                'image' => ['type' => 'image', 'field' => 'image'],
                'parent' => ['type' => 'relation', 'relation' => 'parent', 'field' => 'title'],
                'title' => ['type' => 'text', 'field' => 'title', 'orderable' => true, 'order_field' => 'article_translations.title', 'class' => 'col-2'],
                'slug' => ['type' => 'text', 'field' => 'slug', 'orderable' => true, 'order_field' => 'article_translations.slug'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true, 'orderable' => true],
                'top_menu' => ['type' => 'boolean', 'field' => 'top_menu', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true, 'class' => 'col-1'],
                'created_at' => ['type' => 'date', 'field' => 'created_at', 'orderable' => true],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at', 'orderable' => true],
            ],
            'field_searchable' => [
                /*
                 * This is the 'relation' version which builds a dropdown input for the corresponding relation.
                 * It should be only used when there are only a few records to show.
                 */
                'parent_id' => [
                    'label' => 'parent',
                    'type' => 'relation',
                    'model' => 'article',
                    'relation' => 'parent',
                    'value' => 'id',
                    'field' => 'title',
                    'where' => 'parent_id = 0',
                    'cssClass' => 'selectize',
                ],
                /**
                 * This is the 'suggest' version which builds a dropdown handled by select 2 for the corresponding relation.
                 * It should be used when there are a lot of records to filter.
                 */
                /*'parent_id' => [
                    'label'       => 'Parent page',
                    'type'        => 'suggest',
                    'model'       => 'article',
                    'value'       => 'id',
                    'caption'     => 'title',
                    'is_accessor' => 0,
                    'where'       => 'parent_id = 0',
                ],*/
                'title' => ['type' => 'text', 'label' => 'title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'slug', 'field' => 'slug'],
                'sort' => ['type' => 'text', 'label' => 'sort', 'field' => 'sort'],
            ],
            'field_exportable' => [
                'id' => ['type' => 'integer', 'field' => 'id', 'label' => 'id'],
                'parent' => ['type' => 'relation', 'relation' => 'parent', 'field' => 'title', 'label' => 'parent'],
                'title' => ['type' => 'text', 'label' => 'Title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'Slug', 'field' => 'slug'],
                'sort' => ['type' => 'text', 'label' => 'Sort', 'field' => 'sort'],
            ],
            'joinTable' => "article_translations",
            'foreignJoinKey' => 'article_id',
            'localJoinKey' => 'id',
            'whereFilter' => 'locale="it" ',
            'orderBy' => 'sort,article_translations.title',
            'orderType' => 'ASC',
            'withRelation' => ['translations', 'parent.translations'], // array
            'actions' => [
                'edit' => 1,
                'export_csv' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 1,
                'preview' => 1,
                'view' => 0,
                'selectable' => 1,
            ],
            'showMedia' => 1,
            'showBlock' => 1,
            'showMediaCategory' => 1,
            'showMediaImages' => 1,
            'showMediaDoc' => 1,
            'editTemplate' => 'admin.article.edit',
            'showSeo' => 1,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'blocks' => [
            'model' => 'Block',
            'title' => 'Pages',
            'icon' => 'newspaper',
            'section' =>'cms',
            'field' => ['id',
                'image' => ['type' => 'image', 'field' => 'image'],
                'title' => ['type' => 'text', 'field' => 'title', 'orderable' => true, 'order_field' => 'article_translations.title'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true, 'orderable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at', 'orderable' => true],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at', 'orderable' => true],
            ],
            'field_searchable' => [],
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 1,
                'create' => 0,
                'copy' => 1,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 1,
            'showMediaCategory' => 1,
            'showMediaImages' => 1,
            'showMediaDoc' => 1,
            'showSeo' => 0,
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'hpsliders' => [
            'model' => 'HpSlider',
            'title' => 'Home Sliders',
            'icon' => 'image',
            'section' =>'cms',
            'field' => [
                'id',
                'image' => ['type' => 'image', 'field' => 'image'],
                'title',
                'is_active' => ['type' => 'boolean', 'field' => 'is_active', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 1,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'media' => [
            'model' => 'Media',
            'title' => 'Media',
            'icon' => 'file',
            'section' =>'media',
            'field' => [
                'id',
                'image' => ['type' => 'image', 'field' => 'file_name'],
                'title',
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 0,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'news' => [
            'model' => 'News',
            'title' => 'News',
            'icon' => 'bullhorn',
            'section' =>'cms',
            'field' => [
                'image' => ['type' => 'relation_image', 'relation' => 'imageMedia', 'field' => 'file_name'],
                'image_txt' => ['type' => 'relation_image', 'relation' => 'imageMedia', 'field' => 'file_name'],
                'title',
                'slug',
                'tags' => ['type' => 'relation', 'relation' => 'tags', 'field' => 'title','multiple'=>true],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'export_csv' => 1,
            'field_exportable' => [
                'id' => ['type' => 'integer', 'field' => 'id', 'label' => 'id'],
                'date' => ['type' => 'text', 'field' => 'date', 'label' => 'date'],
                'title' => ['type' => 'text', 'label' => 'Title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'Slug', 'field' => 'slug'],
                'sort' => ['type' => 'text', 'label' => 'Sort', 'field' => 'sort'],
                'created_at' => ['type' => 'datetime', 'label' => 'created_at', 'field' => 'created_at'],
            ],
            'field_searchable' => [
                'from_date' => ['type' => 'date_range', 'label' => 'data_from', 'field' => 'date', 'class' => 'col-6 col-sm-1'],
                'to_date' => ['type' => 'date_range', 'label' => 'data_to', 'field' => 'date', 'class' => 'col-6 col-sm-1'],
                'title' => ['type' => 'text', 'label' => 'title', 'field' => 'title'],
                'tags' => [
                    'label' => 'search_by_tags',
                    'type' => 'relation',
                    'model' => 'tag',
                    'relation' => 'tags',
                    'value' => 'id',
                    'field' => 'title',

                    'cssClass' => 'selectize',
                ],

            ],
            'orderBy' => 'date',
            'orderType' => 'desc',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 1,
                'preview' => 1,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 1,
            'showMediaCategory' => 0,
            'showMediaImages' => 1,
            'showMediaDoc' => 0,
            'showBlock' => 1,
            'showSeo' => 1,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'faqs' => [
            'model' => 'Faq',
            'title' => 'Faqs',
            'icon' => 'question',
            'section' =>'cms',
            'field' => [
                'id',
                'title',
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'edit' => 1,
            'delete' => 1,
            'create' => 1,
            'copy' => 0,
            'preview' => 0,
            'view' => 0,
            'selectable' => 1,
            'showMedia' => 0,
            'showMediaCategory' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add'],
                    /*'submodel' => [
                        'categories' => ['label' => 'Product Categories', 'model' => 'category', 'add' => 1],
                        'productmodels' => ['label' => 'Models', 'model' => 'productmodel', 'add' => 1]
                    ]*/
                ],
            ],
        ],
        'tags' => [
            'model' => 'Tag',
            'title' => 'TagsNews',
            'icon' => 'tag',
            'section' =>'cms',
            'field' => [
                'id',
                'title',
                'slug',
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'locations' => [
            'model' => 'Location',
            'title' => 'Musei',
            'icon' => 'university',
            'section' =>'cms',
            'field' => ['id',
                'image' => ['type' => 'image', 'field' => 'image'],
                'title' => ['type' => 'text', 'field' => 'title', 'orderable' => true, 'order_field' => 'article_translations.title'],
                'slug' => ['type' => 'text', 'field' => 'slug', 'orderable' => true, 'order_field' => 'article_translations.slug'],
                'lat' => ['type' => 'editable', 'field' => 'lat', 'orderable' => true],
                'lng' => ['type' => 'editable', 'field' => 'lng', 'orderable' => true],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true, 'orderable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at', 'orderable' => true],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at', 'orderable' => true],
            ],
            'field_searchable' => [
                'title' => ['type' => 'text', 'label' => 'title', 'field' => 'title'],
            ],
            'field_exportable' => [
                'id' => ['type' => 'integer', 'field' => 'id', 'label' => 'id'],
                'parent' => ['type' => 'relation', 'relation' => 'parent', 'field' => 'title', 'label' => 'parent'],
                'title' => ['type' => 'text', 'label' => 'Title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'Slug', 'field' => 'slug'],
                'sort' => ['type' => 'text', 'label' => 'Sort', 'field' => 'sort'],
            ],
            'joinTable' => "location_translations",
            'foreignJoinKey' => 'location_id',
            'localJoinKey' => 'id',
            'whereFilter' => 'locale="it"',
            'orderBy' => 'sort,location_translations.title',
            'orderType' => 'ASC',
            'withRelation' => ['translations'], // array
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 1,
                'create' => 1,
                'copy' => 1,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 1,
            'showBlock' => 0,
            'showMediaCategory' => 1,
            'showMediaImages' => 1,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'metrics' => [
            'model' => 'Metric',
            'title' => 'Metrics',
            'icon' => 'sort-numeric-up',
            'section' =>'cms',
            'field' => [
                'id',
                'title' => ['type' => 'editable', 'field' => 'title','class' => 'col-2'],
                'value' => ['type' => 'editable', 'field' => 'value', 'orderable' => true, 'class' => 'col-1'],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true, 'class' => 'col-1'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true, 'orderable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'edit' => 1,
            'delete' => 1,
            'create' => 1,
            'copy' => 0,
            'preview' => 0,
            'view' => 0,
            'selectable' => 1,
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 1,
                'create' => 1,
                'copy' => 1,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'projects' => [
            'model' => 'Project',
            'title' => 'Project',
            'icon' => 'project-diagram',
            'section' =>'cms',
            'field' => [
                'id',
                'category' => ['type' => 'relation', 'relation' => 'category', 'field' => 'title'],
                'tags' => ['type' => 'relation', 'relation' => 'tags', 'field' => 'title','multiple'=>true],

                'image' => ['type' => 'image', 'field' => 'image'],
                'title',
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 1,
            'showMediaCategory' => 0,
            'showMediaImages' => 1,
            'showMediaDoc' => 1,
            'showSeo' => 1,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add'],
                    'submodel' => [
                        'categories' => ['label' => 'Product Categories', 'model' => 'category', 'add' => 1, 'icon' => 'folder'],
                    ]
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'products' => [
            'model' => 'Product',
            'title' => 'Product',
            'icon' => 'cube',
            'section' =>'cms',
            'field' => [
                'id',
                'category' => ['type' => 'relation', 'relation' => 'category', 'field' => 'title'],
                'image' => ['type' => 'image', 'field' => 'image'],
                'title',
                'price',
                'full_price',
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'on_sale' => ['type' => 'boolean', 'field' => 'on_sale', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 1,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 1,
            'showMediaCategory' => 0,
            'showMediaImages' => 1,
            'showMediaDoc' => 1,
            'showSeo' => 1,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add'],
                    'submodel' => [
                        'categories' => ['label' => 'Product Categories', 'model' => 'category', 'add' => 1, 'icon' => 'folder'],
                        'productmodels' => ['label' => 'Models', 'model' => 'productmodel', 'add' => 1, 'icon' => 'folder']
                    ]
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'categories' => [
            'model' => 'Category',
            'title' => 'Product Categories',
            'icon' => 'folder',
            'section' =>'cms',
            'field' => [
                'id',
                //'parent' => ['type' => 'relation', 'relation' => 'parentCategory', 'field' => 'title'],
                'image' => ['type' => 'image', 'field' => 'image'],
                'title',
                'slug',
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 1,
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'productmodels' => [
            'model' => 'ProductModel',
            'title' => 'Models',
            'icon' => 'folder',
            'section' =>'cms',
            'field' => [
                'id',
                'image' => ['type' => 'image', 'field' => 'image'],
                'product' => ['type' => 'relation', 'field' => 'title', 'relation' => 'product'],
                'title',
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
            ],
            'orderBy' => 'product_id',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'domains' => [
            'model' => 'Domain',
            'title' => 'Domain',
            'icon' => 'folder',
            'field' => [
                'id',
                'domain',
                'title',
                'value' => ['type' => 'editable', 'field' => 'value'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'domain',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 0,
                'create' => 1,
                'copy' => 1,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'settings' => [
            'model' => 'Setting',
            'title' => 'Setting',
            'icon' => 'wrench',
            'field' => [
                'id',
                'domain',
                'key',
                'value' => ['type' => 'editable', 'field' => 'value'],
                'description' => ['type' => 'editable', 'field' => 'description'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => '\'key\'',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'newsletters' => [
            'model' => 'Newsletter',
            'title' => 'Newsletter',
            'icon' => 'envelope-open-text',
            'section' =>'users',
            'field' => [
                'id',
                'locale' => ['type' => 'locale', 'field' => 'locale'],
                'email',
                'coupon'=> ['type' => 'text', 'field' => 'coupon_code'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
            ],
            'orderBy' => 'created_at',
            'orderType' => 'DESC',
            'actions' => [
                'edit' => 0,
                'delete' => 1,
                'create' => 0,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'showMedia' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                ],
            ],
            'roles' => ['su', 'admin']
        ],
        'contacts' => [
            'model' => 'Contact',
            'icon' => 'envelope',
            'title' => 'Info Request',
            'section' =>'users',
            'field' => [
                'id',
                'email' => ['type' => 'text', 'field' => 'email'],
                'name' => ['type' => 'text', 'field' => 'name'],
                'surname' => ['type' => 'text', 'field' => 'surname'],
                'company' => ['type' => 'text', 'field' => 'company'],
                'message' => ['type' => 'text', 'field' => 'message'],
                'product' => ['type' => 'relation', 'relation' => 'product', 'field' => 'title'],
                'status' => ['type' => 'boolean', 'field' => 'status', 'editable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'id',
            'orderType' => 'DESC',
            'actions' => [
                'edit' => 0,
                'delete' => 0,
                'create' => 0,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 0
            ],
            'password' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'roles' => [
            'model' => 'Role',
            'icon' => 'graduation-cap',
            'title' => 'Roles',
            'section' =>'users',
            'field' => [
                'id',
                'name' => ['type' => 'editable', 'field' => 'name'],
                'display_name' => ['type' => 'editable', 'field' => 'display_name'],
                'description' => ['type' => 'text', 'field' => 'description'],
                'level' => ['type' => 'editable', 'field' => 'level'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ]
            ,
            'roles' => ['su']
        ],
        'socials' => [
            'model' => 'Social',
            'icon' => 'share-alt',
            'title' => 'Social',
            'section' =>'cms',
            'field' => [
                'id',
                'title' => ['type' => 'editable', 'field' => 'title'],
                'icon' => ['type' => 'editable', 'field' => 'icon'],
                'link' => ['type' => 'editable', 'field' => 'link'],
                'is_active' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'sort' => ['type' => 'editable', 'field' => 'sort'],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'sort',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => true,
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'users' => [
            'model' => 'User',
            'icon' => 'users',
            'title' => 'Users',
            'section' =>'users',
            'field' => [
                'id',
                'email' => ['type' => 'editable', 'field' => 'email'],
                'first_name' => ['type' => 'editable', 'field' => 'firstname'],
                'last_name' => ['type' => 'editable', 'field' => 'lastname'],
                'is_active' => ['type' => 'boolean', 'field' => 'is_active', 'editable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'field_searchable' => [
                'email' => ['type' => 'text', 'label' => 'email', 'field' => 'email'],
                'firstname' => ['type' => 'text', 'label' => 'first_name', 'field' => 'firstname'],
                'lastname' => ['type' => 'text', 'label' => 'last_name', 'field' => 'lastname'],
            ],
            'orderBy' => 'firstname',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'impersonated' => 1,
                'selectable' => 1
            ],
            'password' => 1,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin']
        ],

        'orders' => [
            'model' => 'Order',
            'title' => 'Orders',
            'icon' => 'shopping-cart',
            'section' =>'shop',
            //'list_custom_header'=>'admin.list.order-big-amount',
            'field' => [
                'id',
                'created_at' => ['type' => 'date', 'field' => 'created_at', 'orderable' => true],
                'user' => ['type' => 'text', 'field' => 'user_display', 'orderable' => true],
                'reference' => ['type' => 'text', 'field' => 'reference', 'orderable' => true],
                'coupon' => ['type' => 'text', 'field' => 'discount_code', 'class' => 'text-start'],
                //'products' => ['type' => 'text', 'field' => 'products_display', 'class' => 'text-start'],
                'products_cost' => ['type' => 'text', 'field' => 'products_cost_display'],
                'total_cost' => ['type' => 'text', 'field' => 'total_cost_display'],
                'payment' => ['type' => 'text', 'field' => 'payment_method_display'],
                'payment_transaction' => ['type' => 'relation', 'relation' => 'payment', 'field' => 'transaction'],
                //'payment_date' => ['type' => 'relation', 'relation' => 'payment', 'field' => 'created_at'],
                'paid' => ['type' => 'boolean', 'relation' => 'payment', 'model' => 'Payment', 'field' => 'is_paid', 'editable' => true],
                'status' => [
                    'type' => 'relation',
                    'relation' => 'status',
                    'model' => 'OrderStatus',
                    'foreign_key' => 'id',
                    'label_key' => 'title',
                    'label_empty' => 'Seleziona Stato',
                    'order_field' => 'sort',
                    'field' => 'status_id',
                    'editable' => true
                ],
            ],
            'field_searchable' => [
                /*
                * This is the 'relation' version which builds a dropdown input for the corresponding relation.
                * It should be only used when there are only a few records to show.
                */
                'status_id' => [
                    'label' => 'status',
                    'type' => 'relation',
                    'model' => 'OrderStatus',
                    'relation' => 'status',
                    'value' => 'id',
                    'field' => 'title',
                    'where' => '1 = 1',
                    'cssClass' => 'selectize',
                ],

                'from_date' => ['type' => 'date_range', 'label' => 'data_from', 'field' => 'created_at', 'class' => 'col-6 col-sm-1'],
                'to_date' => ['type' => 'date_range', 'label' => 'data_to', 'field' => 'created_at', 'class' => 'col-6 col-sm-1'],
                'reference' => ['type' => 'text', 'label' => 'reference', 'field' => 'reference'],


            ],

            'orderBy' => 'created_at',
            'orderType' => 'DESC',
            'withRelation' => ['payment'], // array
            'viewTemplate' => 'magutti_store::admin.views.order',
            'total' => 'total_cost',
            'actions' => [
                'edit' => 0,
                'export_csv' => 0,
                'delete' => 0,
                'create' => 0,
                'copy' => 0,
                'preview' => 0,
                'view' => 1,
                'view' => 1,
                'selectable' => 0
            ],
            'showMedia' => 0,
            'showMediaCategory' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin']
        ],
        'orderstatuses' => [
            'model' => 'OrderStatus',
            'title' => 'Order Status',
            'icon' => 'credit-card',
            'section' =>'shop',
            'field' => [
                'id',
                'title' => ['type' => 'text', 'field' => 'title'],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true, 'class' => 'col-1'],

                'is_active' => ['type' => 'boolean', 'field' => 'is_active','editable'=>true],
            ],
            'orderBy' => 'id',
            'orderType' => 'ASC',
            'withRelation' => [], // array
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 0,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 0
            ],
            'showMedia' => 0,
            'showMediaCategory' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'paymentmethods' => [
            'model' => 'PaymentMethod',
            'title' => 'Payment Methods',
            'icon' => 'credit-card',
            'section' =>'shop',
            'field' => [
                'id',
                'title' => ['type' => 'text', 'field' => 'title'],
                'fee' => ['type' => 'text', 'field' => 'fee'],
                'code' => ['type' => 'text', 'field' => 'code'],
                'is_active' => ['type' => 'boolean', 'field' => 'is_active','editable'=>true],
            ],
            'orderBy' => 'id',
            'orderType' => 'ASC',
            'withRelation' => [], // array
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 0,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 0
            ],
            'showMedia' => 0,
            'showMediaCategory' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'shipmentmethods' => [
            'model' => 'ShipmentMethod',
            'title' => 'Shipping Methods',
            'icon' => 'truck',
            'section' =>'shop',
            'field' => [
                'id',
                'title' => ['type' => 'text', 'field' => 'title'],
                'fee' => ['type' => 'text', 'field' => 'fee'],
                'free_shipping_from' => ['type' => 'text', 'field' => 'free_shipping_from'],
                'is_active' => ['type' => 'boolean', 'field' => 'is_active','editable'=>true],
            ],
            'orderBy' => 'id',
            'orderType' => 'ASC',
            'withRelation' => [], // array
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 0,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 0
            ],
            'showMedia' => 0,
            'showMediaCategory' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'discounts' => [
            'model' => 'Discount',
            'title' => 'Discount',
            'icon' => 'tags',
            'section' =>'shop',
            'field' => [
                'id',
                'id',
                'code' => ['type' => 'text', 'field' => 'code', 'orderable' => true],
                'amount' => ['type' => 'text', 'field' => 'label'],
                'date_start' => ['type' => 'text', 'field' => 'date_start', 'orderable' => true],
                'date_end' => ['type' => 'text', 'field' => 'date_end', 'orderable' => true],
                'uses' => ['type' => 'text', 'field' => 'uses', 'orderable' => true],
                'available_display' => ['type' => 'false', 'field' => 'available_display', 'orderable' => true],
                'pub' => ['type' => 'boolean', 'field' => 'is_active', 'orderable' => true, 'editable' => true],
            ],
            'orderBy' => 'created_at',
            'orderType' => 'DESC',
            'actions' => [
                'edit' => 1,
                'export_csv' => 0,
                'delete' => 0,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 0
            ],
            'showMedia' => 0,
            'showMediaCategory' => 0,
            'showMediaImages' => 0,
            'showMediaDoc' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin']
        ],
        'adminusers' => [
            'model' => 'AdminUser',
            'icon' => 'users',
            'title' => 'Admin',
            'field' => [
                'id',
                'email' => ['type' => 'editable', 'field' => 'email'],
                'first_name' => ['type' => 'editable', 'field' => 'first_name'],
                'last_name' => ['type' => 'editable', 'field' => 'last_name'],
                'is_active' => ['type' => 'boolean', 'field' => 'is_active', 'editable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'password' => 1,
            'orderBy' => 'first_name',
            'orderType' => 'ASC',
            'actions' => ['edit' => 1,
                'delete' => ['roles' => ['su', 'admin']],
                'create' => ['roles' => ['su', 'admin']],
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => ['roles' => ['su', 'admin']],

                'impersonated' => ['roles' => ['su', 'admin']]
            ],
            'menu' => [
                'tool' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin']
        ],



        /************************  LOCALIZATION **********************/
        'countries' => [
            'model' => 'Country',
            'title' => 'Country',
            'icon' => 'folder',
            'field' => [
                'id',
                'name' => ['type' => 'editable', 'field' => 'name', 'orderable' => true],

                'iso_code' => ['type' => 'editable', 'field' => 'iso_code', 'orderable' => true],
                'vat' => ['type' => 'editable', 'field' => 'vat'],
                'eu' => ['type' => 'boolean', 'field' => 'eu'],
                'is_active' => ['type' => 'boolean', 'field' => 'is_active', 'editable' => true],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'field_searchable' => [
                'name' => ['type' => 'text', 'label' => 'name', 'field' => 'name'],
                'iso_code' => ['type' => 'text', 'label' => 'code', 'field' => 'iso_code'],
            ],
            'orderBy' => 'name',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 0,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 1,
                /* GF_ma  custom  view
                'editTemplate' =>'admin.special.edit_audit',
                'viewTemplate' =>'admin.special.view_audit',
                */
                'selectable' => 1
            ],
            'showMedia' => 0,
            'showSeo' => 0,
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'provinces' => [
            'model' => 'Province',
            'icon' => 'flag',
            'title' => 'Province',
            'field' => [
                'id',
                'state' => ['type' => 'relation', 'field' => 'title', 'relation' => 'state'],
                'code' => ['type' => 'editable', 'field' => 'code'],
                'title' => ['type' => 'editable', 'field' => 'title'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'field_searchable' => [
                'title' => ['type' => 'text', 'label' => 'title', 'field' => 'title'],
            ],
            'field_exportable' => [
                'id' => ['type' => 'integer', 'field' => 'id', 'label' => 'id'],
                'title' => ['type' => 'text', 'label' => 'Title', 'field' => 'title'],
                'code' => ['type' => 'text', 'label' => 'Code', 'field' => 'code'],

            ],
            'orderBy' => 'title',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'export_csv'   => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'states' => [
            'model' => 'State',
            'icon' => 'flag',
            'title' => 'State',
            'field' => [
                'id',
                'country' => ['type' => 'relation', 'field' => 'name', 'relation' => 'country'],
                'title' => ['type' => 'editable', 'field' => 'title'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'editable' => true],
                'created_at' => ['type' => 'date', 'field' => 'created_at'],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at'],
            ],
            'orderBy' => 'title',
            'orderType' => 'ASC',
            'actions' => [
                'edit' => 1,
                'delete' => 1,
                'create' => 1,
                'copy' => 0,
                'preview' => 0,
                'view' => 0,
                'selectable' => 1
            ],
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su']
        ],
        'examples' => [
            'model' => 'Example',
            'title' => 'Example',
            'icon' => 'graduation-cap',
            'section' =>'example',

            'field' => [
                'id',
                'date' => ['type' => 'text', 'field' => 'date', 'orderable' => true],
                'article' => ['type' => 'relation', 'relation' => 'article', 'field' => 'title'],
                'article_2' => [
                    'type' => 'relation',
                    'relation' => 'article_2',
                    'field' => 'title',
                    'orderable' => true,
                    'order_field' => 'article_translations.title',
                    'roles' => ['su', 'admin']
                ],
                'image' => ['type' => 'image', 'field' => 'image'],
                //'image_media_id' => ['type' => 'relation_image', 'relation' => 'imageMedia', 'field' => 'file_name'],
                'title' => ['type' => 'text', 'field' => 'title', 'orderable' => true],
                'slug' => ['type' => 'text', 'field' => 'slug', 'orderable' => true, 'order_field' => 'article_translations.title'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'orderable' => true, 'editable' => false],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true],
                'readonly' => ['type' => 'readonly', 'field' => 'title', 'orderable' => true],
                'custom' => ['type' => 'custom', 'field' => 'title', 'orderable' => true, 'class' => 'col-3'],
                'color' => ['type' => 'color', 'field' => 'color'],

                'status_id' => [
                    'type' => 'relation',
                    'relation' => 'statusType',
                    'model' => 'Domain',
                    'filter' => ['domain' => 'imagetype'],
                    'scopes' => ['published'],
                    'foreign_key' => 'id',
                    'label_key' => 'title',
                    'label_empty' => 'Seleziona Stato',
                    'order_field' => 'sort',
                    'field' => 'status_id',
                    'editable' => true
                ],
                'created_at' => ['type' => 'date', 'field' => 'created_at', 'orderable' => true],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at', 'orderable' => true],
            ],
            'field_searchable' => [
                /*
                * This is the 'relation' version which builds a dropdown input for the corresponding relation.
                * It should be only used when there are only a few records to show.
                */
                'article_id' => [
                    'label' => 'article',
                    'type' => 'relation',
                    'model' => 'article',
                    'relation' => 'article',
                    'value' => 'id',
                    'field' => 'title',
                    'where' => '1 = 1',
                    'cssClass' => 'selectize',
                ],
                /**
                 * This is the 'suggest' version which builds a dropdown handled by select 2 for the corresponding relation.
                 * It should be used when there are a lot of records to filter.
                 */
                'article_2_id' => [
                    'label' => 'article_2',
                    'type' => 'suggest',
                    'model' => 'article',
                    'value' => 'id',
                    'caption' => 'title',
                    'is_accessor' => 0,
                    'where' => '1 = 1',
                    'roles' => ['su', 'admin']
                ],
                //'date'   => ['type' => 'date', 'label' => 'date_format', 'field' => 'date'],
                'from_date' => ['type' => 'date_range', 'label' => 'data_from', 'field' => 'date', 'class' => 'col-6 col-sm-1'],
                'to_date' => ['type' => 'date_range', 'label' => 'data_to', 'field' => 'date', 'class' => 'col-6 col-sm-1'],
                'title' => ['type' => 'text', 'label' => 'title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'slug', 'field' => 'slug'],
                'sort' => ['type' => 'number', 'label' => 'sort', 'field' => 'sort', 'mode' => 'strict'],
            ],
            'field_exportable' => [
                'id' => ['type' => 'integer', 'field' => 'id', 'label' => 'id'],
                'parent' => ['type' => 'relation', 'relation' => 'parent', 'field' => 'title', 'label' => 'parent'],
                'title' => ['type' => 'text', 'label' => 'Title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'Slug', 'field' => 'slug'],
                'sort' => ['type' => 'text', 'label' => 'Sort', 'field' => 'sort'],
            ],
            'joinTable' => "article_translations",
            'foreignJoinKey' => 'article_id',
            'localJoinKey' => 'id',
            'joinFields' => ['article_translations.id as trans_id'],
            'whereFilter' => 'article_translations.locale="en" ',
            'orderBy' => 'article_translations.title,sort',
            'orderType' => 'ASC',
            'withRelation' => ['media'],
            'actions' => [
                'edit' => 1,
                'export_csv' => 1,
                'delete' => ['roles' => ['su', 'admin']],
                'create' => 1,
                'copy' => 1,
                'preview' => 0,
                'view' => 1,
                'selectable' => ['roles' => ['su', 'admin']],
            ],
            'viewTemplate' => 'admin.views.example',
            'showMedia' => 1,
            'showMediaCropper' => 1,
            'mediaCropper' => [
                'width' => 400,
                'height' => 400,
                'ratio' => 1,
                'fill' => 'transparent',
                'format' => 'jpeg',
                'extension' => 'jpg'
            ],
            'showMediaCategory' => 0,
            'showMediaImages' => 1,
            'showMediaDoc' => 0,
            'showSeo' => 1,
            'tabs' => ['check_boxes' => ['title' => 'check_boxes_types', 'icon' => 'fa-check-square', 'context' => 'check_boxes'],
            ],
            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                    'action' => ['add']
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],

        'custom_resources' => [
            'model' => 'Example',
            'title' => 'Custom Items',
            'icon' => 'graduation-cap',
            'section' =>'example',
            'extra_url'=>'custom_resources',
            'field' => [
                'id',
                'date' => ['type' => 'text', 'field' => 'date', 'orderable' => true],
                'article' => ['type' => 'relation', 'relation' => 'article', 'field' => 'title'],
                'article_2' => [
                    'type' => 'relation',
                    'relation' => 'article_2',
                    'field' => 'title',
                    'orderable' => true,
                    'order_field' => 'article_translations.title',
                    'roles' => ['su', 'admin']
                ],
                'image' => ['type' => 'image', 'field' => 'image'],
                //'image_media_id' => ['type' => 'relation_image', 'relation' => 'imageMedia', 'field' => 'file_name'],
                'title' => ['type' => 'text', 'field' => 'title', 'orderable' => true],
                'slug' => ['type' => 'text', 'field' => 'slug', 'orderable' => true, 'order_field' => 'article_translations.title'],
                'pub' => ['type' => 'boolean', 'field' => 'pub', 'orderable' => true, 'editable' => false],
                'sort' => ['type' => 'editable', 'field' => 'sort', 'orderable' => true],

                'created_at' => ['type' => 'date', 'field' => 'created_at', 'orderable' => true],
                'updated_at' => ['type' => 'date', 'field' => 'updated_at', 'orderable' => true],
            ],
            'field_searchable' => [
                /*
                * This is the 'relation' version which builds a dropdown input for the corresponding relation.
                * It should be only used when there are only a few records to show.
                */
                'article_id' => [
                    'label' => 'article',
                    'type' => 'relation',
                    'model' => 'article',
                    'relation' => 'article',
                    'value' => 'id',
                    'field' => 'title',
                    'where' => '1 = 1',
                    'cssClass' => 'selectize',
                ],
                /**
                 * This is the 'suggest' version which builds a dropdown handled by select 2 for the corresponding relation.
                 * It should be used when there are a lot of records to filter.
                 */
                'article_2_id' => [
                    'label' => 'article_2',
                    'type' => 'suggest',
                    'model' => 'article',
                    'value' => 'id',
                    'caption' => 'title',
                    'is_accessor' => 0,
                    'where' => '1 = 1',
                    'roles' => ['su', 'admin']
                ],
                //'date'   => ['type' => 'date', 'label' => 'date_format', 'field' => 'date'],
                'from_date' => ['type' => 'date_range', 'label' => 'data_from', 'field' => 'date', 'class' => 'col-6 col-sm-1'],
                'to_date' => ['type' => 'date_range', 'label' => 'data_to', 'field' => 'date', 'class' => 'col-6 col-sm-1'],
                'title' => ['type' => 'text', 'label' => 'title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'slug', 'field' => 'slug'],
                'sort' => ['type' => 'number', 'label' => 'sort', 'field' => 'sort', 'mode' => 'strict'],
            ],
            'field_exportable' => [
                'id' => ['type' => 'integer', 'field' => 'id', 'label' => 'id'],
                'parent' => ['type' => 'relation', 'relation' => 'parent', 'field' => 'title', 'label' => 'parent'],
                'title' => ['type' => 'text', 'label' => 'Title', 'field' => 'title'],
                'slug' => ['type' => 'text', 'label' => 'Slug', 'field' => 'slug'],
                'sort' => ['type' => 'text', 'label' => 'Sort', 'field' => 'sort'],
            ],
            'joinTable' => "article_translations",
            'foreignJoinKey' => 'article_id',
            'localJoinKey' => 'id',
            'joinFields' => ['article_translations.id as trans_id'],
            'whereFilter' => 'article_translations.locale="en" ',
            'orderBy' => 'article_translations.title,sort',
            'orderType' => 'ASC',
            'withRelation' => ['media'],
            'actions' => [
                'edit' => 0,
                'selectable' => ['roles' => ['su', 'admin']],
            ],
            'viewTemplate' => 'admin.views.example',
            'showMedia' => 1,
            'showMediaCropper' => 1,
            'mediaCropper' => [
                'width' => 400,
                'height' => 400,
                'ratio' => 1,
                'fill' => 'transparent',
                'format' => 'jpeg',
                'extension' => 'jpg'
            ],
            'menu' => [
                'home' => false,
                'top-bar' => [
                    'show' => false,

                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
        'custom_url ' => [
            'title' => 'Magutti.com',
            'icon' => 'share-alt',
            'extra_url' => 'https://magutti.com/',
            'target_url' => '_new',
            'section' => ' ',

            'menu' => [
                'home' => true,
                'top-bar' => [
                    'show' => true,
                ],
            ],
            'roles' => ['su', 'admin', 'user']
        ],
    ],
];
