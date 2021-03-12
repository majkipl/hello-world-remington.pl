<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThxController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/* FRONTEND */

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/formularz', [ApplicationController::class, 'form'])->name('front.application.form');
Route::post('/formularz/zapisz', [ApplicationController::class, 'store'])->name('front.application.save');
Route::get('/formularz/podziekowania', [ThxController::class, 'form'])->name('front.thx.form');

/* BACKEND */

Route::middleware(['auth', 'verified', 'jwt.access'])->group(function () {
    Route::get('/panel', [\App\Http\Controllers\Panel\HomeController::class, 'index'])->name('back.home');

    Route::middleware(['can:isAdmin'])->group(function () {
        Route::get('/panel/zgloszenie', [\App\Http\Controllers\Panel\ApplicationController::class, 'index'])->name('back.application');
        Route::get('/panel/zgloszenie/{application}', [\App\Http\Controllers\Panel\ApplicationController::class, 'show'])->name('back.application.show');

        Route::get('/panel/sklep', [\App\Http\Controllers\Panel\ShopController::class, 'index'])->name('back.shop');
        Route::get('/panel/sklep/dodaj', [\App\Http\Controllers\Panel\ShopController::class, 'create'])->name('back.shop.create');
        Route::get('/panel/sklep/zmien/{shop}', [\App\Http\Controllers\Panel\ShopController::class, 'edit'])->name('back.shop.edit');
        Route::get('/panel/sklep/{shop}', [\App\Http\Controllers\Panel\ShopController::class, 'show'])->name('back.shop.show');

        Route::get('/panel/skad-wiesz', [\App\Http\Controllers\Panel\WhenceController::class, 'index'])->name('back.whence');
        Route::get('/panel/skad-wiesz/dodaj', [\App\Http\Controllers\Panel\WhenceController::class, 'create'])->name('back.whence.create');
        Route::get('/panel/skad-wiesz/zmien/{whence}', [\App\Http\Controllers\Panel\WhenceController::class, 'edit'])->name('back.whence.edit');
        Route::get('/panel/skad-wiesz/{whence}', [\App\Http\Controllers\Panel\WhenceController::class, 'show'])->name('back.whence.show');

        Route::get('/panel/produkt', [\App\Http\Controllers\Panel\ProductController::class, 'index'])->name('back.product');
        Route::get('/panel/produkt/dodaj', [\App\Http\Controllers\Panel\ProductController::class, 'create'])->name('back.product.create');
        Route::get('/panel/produkt/zmien/{product}', [\App\Http\Controllers\Panel\ProductController::class, 'edit'])->name('back.product.edit');
        Route::get('/panel/produkt/{product}', [\App\Http\Controllers\Panel\ProductController::class, 'show'])->name('back.product.show');

        Route::get('/panel/link', [\App\Http\Controllers\Panel\LinkController::class, 'index'])->name('back.link');
        Route::get('/panel/link/dodaj', [\App\Http\Controllers\Panel\LinkController::class, 'create'])->name('back.link.create');
        Route::get('/panel/link/zmien/{link}', [\App\Http\Controllers\Panel\LinkController::class, 'edit'])->name('back.link.edit');
        Route::get('/panel/link/{link}', [\App\Http\Controllers\Panel\LinkController::class, 'show'])->name('back.link.show');
    });
});
