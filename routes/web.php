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

Route::get('/', [App\Http\Controllers\HomeController::class, 'main'])->name('main');
Route::get('/advices', [App\Http\Controllers\HomeController::class, 'advices'])->name('advices');
Route::get('/rules', [App\Http\Controllers\HomeController::class, 'rules'])->name('rules');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('phones', App\Http\Controllers\PhoneController::class);
    Route::resource('comments', App\Http\Controllers\CommentController::class);
    Route::resource('cards', App\Http\Controllers\CardController::class);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/frauds/create', [App\Http\Controllers\FraudController::class, 'create'])->name('fraud.create');
    Route::post('/frauds/store', [App\Http\Controllers\FraudController::class, 'store'])->name('fraud.store');
});
