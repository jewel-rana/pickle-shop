<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDeliveryController;
use App\Http\Controllers\ProductController;
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

Route::apiResource('product', ProductController::class);
Route::delete('cart/remove/{any}', [CartController::class, 'destroy']);
Route::apiResource('cart', CartController::class)->only(['store']);
Route::group(['prefix' => 'order'], function() {
   Route::apiResource('delivery', OrderDeliveryController::class)->except(['destory']);
});
Route::apiResource('order', OrderController::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
