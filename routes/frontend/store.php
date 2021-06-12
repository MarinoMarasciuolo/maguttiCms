<?php

use App\maguttiCms\Domain\Store\Api\ResendOrderNotification;
use App\maguttiCms\Website\Controllers\Store\OrderSendController;
use App\maguttiCms\Website\Controllers\Store\OrderPaymentController;
use App\maguttiCms\Website\Controllers\Store\OrderResultController;

use App\maguttiCms\Domain\Store\Controllers\MainStoreController;
use App\maguttiCms\Domain\Store\Controllers\CartController;
use App\maguttiCms\Domain\Store\Controllers\AddressStepController;
use App\maguttiCms\Domain\Store\Controllers\ConfirmStepController;
use App\maguttiCms\Domain\Store\Controllers\PaymentMethodStepController;
use App\maguttiCms\Domain\Store\Controllers\Payment\StorePaymentManagerController;

use App\maguttiCms\Domain\Store\Notifications\NewOrderNotification;

use App\maguttiCms\Domain\Store\Api\CouponDeleteController;
use App\maguttiCms\Domain\Store\Api\CouponValidateController;
use App\maguttiCms\Domain\Store\Api\StoreAPIController;


Route::get('/cart/', CartController::class)->middleware('storeenabled')->name('cart');
Route::get('/cart/address', [AddressStepController::class, 'view'])->middleware('storeenabled', 'auth')->name('cart.step_1');
Route::post('/cart/address', [AddressStepController::class, 'store'])->middleware('storeenabled');
Route::get('/cart/payment', [PaymentMethodStepController::class, 'view'])->middleware('storeenabled')->name('cart.payment');
Route::post('/cart/payment', [PaymentMethodStepController::class, 'store'])->middleware('storeenabled');
Route::get('/cart/resume', [ConfirmStepController::class, 'view'])->middleware('storeenabled')->name('cart.resume');
Route::post('/cart/resume', [ConfirmStepController::class, 'view'])->middleware('storeenabled');

Route::get('/order-send/', [StorePaymentManagerController::class, 'handle'])->middleware(['storeenabled', 'auth'])->name('order.send');
Route::get('/order-confirm/{token}', [OrderResultController::class, 'view'])->middleware(['storeenabled', 'auth'])->name('order.confirm.success');

Route::get('/order-payment-confirm/{token?}', [OrderPaymentController::class, 'orderPaymentConfirm'])->middleware(['storeenabled', 'auth'])->name('order.payment.cancel');
Route::get('/order-payment-cancel/{cart:token}', [OrderPaymentController::class, 'cancel'])->middleware(['storeenabled', 'auth'])->name('order.payment.cancel');


Route::get('/order/mailable/{order:token}', function (\App\Order $order) {
    return (new NewOrderNotification($order))->toMail($order->user);
});


Route::get('/order-login/', [MainStoreController::class,'orderLogin'])->name('cart.login')->middleware(['storeenabled']);
Route::get('/order-submit/', [MainStoreController::class,'orderSubmit'])->middleware(['storeenabled'])->name('cart.detail');


/*
|--------------------------------------------------------------------------
| STORE API
|--------------------------------------------------------------------------
*/

Route::group([], function () {
    // store section
    // store section
    Route::post('api/store/cart-item-add', [StoreAPIController::class, 'storeCartItemAdd']);
    Route::post('api/store/cart-item-remove', [StoreAPIController::class, 'storeCartItemRemove']);
    Route::post('api/store/cart-item-update', [StoreAPIController::class, 'updateItemQuantity']);
    Route::get('api/store/order-calc', [StoreAPIController::class, 'storeOrderCalc']);
    Route::get('api/store/validate-coupon', CouponValidateController::class);
    Route::delete('api/store/coupon-remove', CouponDeleteController::class);
    Route::get('api/store/resend-order-notification/{order:token}', ResendOrderNotification::class);
});