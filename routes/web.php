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

//Frontend
Route::get('/', [App\Http\Controllers\Frontend\MainController::class, 'main'])->name('main');
Route::get('/advices', [App\Http\Controllers\Frontend\MainController::class, 'advices'])->name('advices');
Route::get('/rules', [App\Http\Controllers\Frontend\MainController::class, 'rules'])->name('rules');

Route::get('/frauds', [App\Http\Controllers\Frontend\FraudController::class, 'index'])->name('fraud.index');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/frauds/create', [App\Http\Controllers\Frontend\FraudController::class, 'create'])->name('fraud.create');
    Route::post('/frauds/store', [App\Http\Controllers\Frontend\FraudController::class, 'store'])->name('fraud.store');
});

//Admin
Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('phones', App\Http\Controllers\Admin\PhoneController::class);
    Route::resource('comments', App\Http\Controllers\Admin\CommentController::class);
    Route::resource('cards', App\Http\Controllers\Admin\CardController::class);
});

