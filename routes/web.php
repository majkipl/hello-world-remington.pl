<?php

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('front.home');

/* BACKEND */

Route::middleware(['auth', 'verified', 'jwt.access'])->group(function () {
    Route::get('/panel', [\App\Http\Controllers\Panel\HomeController::class, 'index'])->name('back.home');

    Route::middleware(['can:isAdmin'])->group(function () {
        //
    });
});
