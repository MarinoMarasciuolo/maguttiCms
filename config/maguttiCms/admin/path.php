<?php

return [
    'repository'     => env('ASSET_PUBLIC_PATH','').'media/',
    'img_repository' => env('ASSET_PUBLIC_PATH','').'media/images/',
    'img_save'       => env('ASSET_PUBLIC_PATH','').'media/images/cache/',
    'doc_repository' => env('ASSET_PUBLIC_PATH','').'media/docs/',
    'users_repository' => env('ASSET_PUBLIC_PATH','').'media/users/',

    'media_img_repository' => env('ASSET_PUBLIC_PATH','').'media/images/',
    'media_doc_repository' => env('ASSET_PUBLIC_PATH','').'media/docs/',

    'cms' => env('ASSET_PUBLIC_PATH','').'cms/',
    'cms_assets' => env('ASSET_PUBLIC_PATH','').'cms/',
    'cms_js' => env('ASSET_PUBLIC_PATH','').'cms/js/',
    'cms_css' => env('ASSET_PUBLIC_PATH','').'cms/css/',

    'assets'     	 => env('ASSET_PUBLIC_PATH',''),
    'common_js'      => env('ASSET_PUBLIC_PATH','').'js/',
    'js_vendor'      => env('ASSET_PUBLIC_PATH','').'js/vendor/',
    'plugins'        => env('ASSET_PUBLIC_PATH','').'plugins/',
	'common_css'     => env('ASSET_PUBLIC_PATH','').'css/',
	'css_vendor'     => env('ASSET_PUBLIC_PATH','').'css/vendor/',

	'user_upload'    => 'upload/',

    'export_data'     => 'export/',
    'shared'         => 'shared_data/',


];
