<?php

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\maguttiCms\Middleware\AdminRole;
use App\maguttiCms\Middleware\AdminEditRole;
use App\maguttiCms\Middleware\AdminStoreRole;
use App\maguttiCms\Middleware\AdminDeleteRole;
use App\maguttiCms\Admin\Controllers\Auth\LoginController;
use App\maguttiCms\Admin\Controllers\AdminPagesController;
use App\maguttiCms\Admin\Controllers\AdminExportController;
use App\maguttiCms\Admin\Controllers\AdminImpersonateController;
use App\maguttiCms\Admin\Controllers\Auth\ForgotPasswordController;
use App\maguttiCms\Admin\Controllers\Auth\ResetPasswordController;

Route::group(['namespace' => 'Admin', 'middleware' => ['adminauth', 'setlocaleadmin']], function () {

    Route::get('/', [AdminPagesController::class, 'home'])->name('admin_dashboard');

    Route::get('/list/{section?}/{sub?}', [AdminPagesController::class, 'lista'])->middleware(AdminRole::class)->name('admin_list');
    Route::get('/view/{section}/{id?}/{type?}', [AdminPagesController::class, 'view'])->middleware(AdminRole::class)->name('admin_view');

    Route::get('/create/{section}', [AdminPagesController::class, 'create'])->middleware(AdminRole::class)->name('admin_create');
    Route::post('/create/{section}', [AdminPagesController::class, 'store'])->middleware(AdminStoreRole::class)->name('admin_store');

    Route::get('/edit/{section}/{id?}/{type?}', [AdminPagesController::class, 'edit'])->middleware(AdminEditRole::class)->name('admin_edit');
    Route::post('/edit/{section}/{id?}', [AdminPagesController::class, 'update'])->middleware(AdminStoreRole::class)->name('admin_update');

    Route::get('/editmodal/{section}/{id?}/{type?}', [AdminPagesController::class, 'editmodal'])->name('admin_modal_edit');
    Route::post('/editmodal/{section}/{id?}', [AdminPagesController::class, 'updatemodal'])->name('admin_modal_update');

    Route::get('/delete/{section}/{id?}', [AdminPagesController::class, 'destroy'])->middleware(AdminDeleteRole::class)->name('admin_destroy');
    Route::get('/duplicate/{section}/{id?}/{type?}', [AdminPagesController::class, 'duplicate'])->name('admin_duplicate');

    Route::get('/file_view/{section}/{id}/{key}', [AdminPagesController::class, 'file_view'])->name('file_view');

    Route::group(array('prefix' => 'impersonated', 'middleware' => ['adminimpersonate']), function () {
        Route::get('/adminusers/{id?}', [AdminImpersonateController::class,'impersonateadmin'])->name('impersonate_admin');
        Route::get('/users/{id?}', [AdminImpersonateController::class,'impersonateuser'])->name('impersonate_user');
    });

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */
    Route::prefix('api')->group(base_path('routes/admin/api.php'));

    Route::get('/exportlist/{section?}/{sub?}', [AdminExportController::class,'list'])->name('admin_exportlist');
});
/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'guest:admin'], function () {
    // Admin Auth and Password routes...
    Route::get('login', [LoginController::class, 'showLoginForm']);
    Route::post('login', [LoginController::class, 'login']);
    // Password Reset Routes...
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
});

Route::get('logout', [LoginController::class, 'logout']);

