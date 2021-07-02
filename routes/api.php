<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDeliveryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SimilarProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'product'], function() {
    Route::get('similar/{id}', [SimilarProductController::class, 'similarProducts'])->name('product.similar');
});
Route::apiResource('product', ProductController::class);
Route::delete('cart/remove/{any}', [CartController::class, 'destroy']);
Route::apiResource('cart', CartController::class)->only(['store']);
Route::apiResource('offer', OfferController::class);
Route::group(['prefix' => 'order'], function() {
   Route::apiResource('delivery', OrderDeliveryController::class)->except(['destroy']);
});
Route::apiResource('order', OrderController::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
