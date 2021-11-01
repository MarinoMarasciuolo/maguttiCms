<?php


use App\maguttiCms\Admin\Controllers\AjaxImageCropperController;
use App\maguttiCms\Admin\Controllers\AjaxMediaListController;
use App\maguttiCms\Admin\Controllers\AjaxUploadifiveController;
use App\maguttiCms\Admin\Controllers\AjaxUploadifiveMediaController;
use App\maguttiCms\Admin\Controllers\AjaxUploadMediaTinyMCE;
use App\maguttiCms\Api\V1\Controllers\AdminFileMangerController;
use App\maguttiCms\Middleware\AdminSuggestRole;
use App\maguttiCms\Admin\Controllers\AjaxController;
use App\maguttiCms\Api\V1\Controllers\AdminCrudController;
use App\maguttiCms\Api\V1\Controllers\AdminServicesController;
use App\maguttiCms\Admin\Controllers\SuggestAjaxController;

Route::group([], function () {
    /*
    |--------------------------------------------------------------------------
    | MEDIA LIBRARY
    |--------------------------------------------------------------------------
    */
    Route::post('uploadifiveSingle/', [AjaxUploadifiveController::class, 'handle']);
    Route::post('uploadifiveMedia/', [AjaxUploadifiveMediaController::class,'handle']);
    Route::post('cropperMedia/', [AjaxImageCropperController::class,'handle']);
    Route::get('updateHtml/media/{model?}', [AjaxMediaListController::class, 'updateModelMediaList']);
    Route::get('updateHtml/{mediaType?}/{model?}/{id?}', [AjaxMediaListController::class, 'updateMediaList']);
    Route::get('updateMediaSortList/', [AjaxMediaListController::class, 'updateMediaSortList']);
    Route::post('upload-media-tinymce/', [AjaxUploadMediaTinyMCE::class, 'handle']);

    /*
    |--------------------------------------------------------------------------
    | API LIBRARY
    |--------------------------------------------------------------------------
    */

    Route::get('api/suggest', ['as' => 'api.suggest', 'uses' => [SuggestAjaxController::class,'suggest']])->middleware(AdminSuggestRole::class);
    Route::get('dashboard', [AdminServicesController::class,'dashboard']);
    Route::get('sections', [AdminServicesController::class,'sections']);
    Route::get('nav-bar', [AdminServicesController::class,'navbar']);

    /*
    |--------------------------------------------------------------------------
    | API FILE MANAGER
    |--------------------------------------------------------------------------
    */

    Route::prefix('file-manager')->group(function () {
        Route::get('grid/{id?}', [AdminFileMangerController::class,'index']);
        Route::get('edit/{id}',  [AdminFileMangerController::class,'edit']);
        Route::post('edit/{id}', [AdminFileMangerController::class,'update']);
        Route::get('delete/{id}', [AdminFileMangerController::class,'deleteMedia']);
    });

    Route::post('filemanager/upload', [AjaxController::class, 'uploadFileManager']);
    /*
    |--------------------------------------------------------------------------
    | API SERVICES LIBRARY
    |--------------------------------------------------------------------------
    */

    Route::post('services/generator', [AdminServicesController::class,'generator']);

    /*
    |--------------------------------------------------------------------------
    | CRUD LIBRARY
    |--------------------------------------------------------------------------
    */
    Route::post('create/{model}', [AdminCrudController::class,'create']);
    Route::post('update/{model}/{id}', [AdminCrudController::class,'update']);
    Route::get('update/{method}/{model?}/{id?}', [AjaxController::class, 'update']);
    Route::get('delete/{model?}/{id?}', [AjaxController::class, 'delete']);

});
