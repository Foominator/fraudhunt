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

Route::get('/set-locale/{locale}', [App\Http\Controllers\Frontend\MainController::class, 'setLocale'])->name('set-locale');

Auth::routes();

//Admin
Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('phones', App\Http\Controllers\Admin\PhoneController::class);
    Route::resource('comments', App\Http\Controllers\Admin\CommentController::class);
    Route::resource('cards', App\Http\Controllers\Admin\CardController::class);
});
