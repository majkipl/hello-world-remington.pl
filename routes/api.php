<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\WhenceController;
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

Route::get('/product/link/{product}', [LinkController::class, 'product'])->name('api.product.links');

Route::middleware(['api.keys'])->group(function () {
    Route::middleware(['api.auth'])->group(function () {
        Route::get('/applications', [ApplicationController::class, 'index'])->name('api.application');

        Route::get('/shops', [ShopController::class, 'index'])->name('api.shop');
        Route::post('/shops', [ShopController::class, 'add'])->name('api.shop.add');
        Route::put('/shops', [ShopController::class, 'update'])->name('api.shop.update');
        Route::delete('/shops/{shop}', [ShopController::class, 'delete'])->name('api.shop.delete');

        Route::get('/whences', [WhenceController::class, 'index'])->name('api.whence');
        Route::post('/whences', [WhenceController::class, 'add'])->name('api.whence.add');
        Route::put('/whences', [WhenceController::class, 'update'])->name('api.whence.update');
        Route::delete('/whences/{whence}', [WhenceController::class, 'delete'])->name('api.whence.delete');

        Route::get('/products', [ProductController::class, 'index'])->name('api.product');
        Route::post('/products', [ProductController::class, 'add'])->name('api.product.add');
        Route::put('/products', [ProductController::class, 'update'])->name('api.product.update');
        Route::delete('/products/{product}', [ProductController::class, 'delete'])->name('api.product.delete');
        Route::get('/products/{product}/links', [LinkController::class, 'byProduct'])->name('api.product.link');

        Route::get('/links', [LinkController::class, 'index'])->name('api.link');
        Route::post('/links', [LinkController::class, 'add'])->name('api.link.add');
        Route::put('/links', [LinkController::class, 'update'])->name('api.link.update');
        Route::delete('/links/{link}', [LinkController::class, 'delete'])->name('api.link.delete');
    });
});
