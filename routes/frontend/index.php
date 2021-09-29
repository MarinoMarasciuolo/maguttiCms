<?php


/*
|--------------------------------------------------------------------------
| FRONT END API
|--------------------------------------------------------------------------
*/


use App\maguttiCms\Website\Controllers\APIController;
use App\maguttiCms\Website\Controllers\ContactController;
use App\maguttiCms\Website\Controllers\FaqController;
use App\maguttiCms\Website\Controllers\NewsController;
use App\maguttiCms\Website\Controllers\PagesController;
use App\maguttiCms\Website\Controllers\StoreAPIController;
use App\maguttiCms\Website\Controllers\ProductsController;
use App\maguttiCms\Website\Controllers\WebsiteFormController;

use App\maguttiCms\Website\Controllers\Auth\LoginController;
use App\maguttiCms\Website\Controllers\Auth\RegisterController;
use App\maguttiCms\Website\Controllers\Auth\ResetPasswordController;
use App\maguttiCms\Website\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| FRONT END
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'usercart']], function () {
    // Api
    Route::post('/api/newsletter', [APIController::class, 'subscribeNewsletter']);

    // Authentication routes...
    Route::get('users/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('users/login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');;

    // Reserved area user routes
    Route::group(['middleware' => ['auth']], function () {
        Route::prefix('users')->group(base_path('routes/frontend/reserved_area.php'));
    });

    // Registration routes...
    Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset Routes...
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    // Pages routes...
    Route::get('/', [PagesController::class, 'home']);

    /*
    |--------------------------------------------------------------------------
    | NEWS
    |--------------------------------------------------------------------------
    */
    Route::prefix('news')->group(function () {
        Route::get('', [NewsController::class, 'news']);
        Route::get('/tags/{tags}', [NewsController::class, 'newsByTags']);
        Route::get('/{slug}', [NewsController::class, 'news']);
    });

    /*
    |--------------------------------------------------------------------------
    | FAQS
    |--------------------------------------------------------------------------
    */
    Route::prefix('faq')->group(function () {
        Route::get('/', [FaqController::class,'index']);
        Route::get('/{slug}', [FaqController::class, 'index']);
    });

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */
    Route::get(LaravelLocalization::transRoute("routes.category"), [ProductsController::class, 'category'])->name('shop.index');
    Route::get(LaravelLocalization::transRoute("routes.products"), [ProductsController::class, 'products']);


    Route::get(LaravelLocalization::transRoute("routes.contacts"), ContactController::class);
    Route::post('/contacts/', [WebsiteFormController::class, 'getContactUsForm']);

    // store page
    Route::group(['as'=>'store.'],base_path('routes/frontend/store.php'));

    // store social_auth
    Route::group(['as'=>'social_auth.'],base_path('routes/frontend/social_auth.php'));

    Route::get('/{parent}/{child}', [PagesController::class, 'pages']);
    Route::get('/{parent?}/', [PagesController::class, 'pages']);
});
