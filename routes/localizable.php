<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Lang;

Route::get('/', [App\Http\Controllers\Frontend\MainController::class, 'main'])->name('main');
Route::get('/rules', [App\Http\Controllers\Frontend\MainController::class, 'rules'])->name('rules');
Route::get('/advices', [App\Http\Controllers\Frontend\MainController::class, 'advices'])->name('advices');
// To translate route path use locale
//Route::get(Lang::uri('/advices'), [App\Http\Controllers\Frontend\MainController::class, 'advices'])->name('advices');

Route::get('/frauds', [App\Http\Controllers\Frontend\FraudController::class, 'index'])->name('fraud.index');
Route::get('/frauds/search', [App\Http\Controllers\Frontend\FraudController::class, 'search'])->name('fraud.search');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/frauds/create', [App\Http\Controllers\Frontend\FraudController::class, 'create'])->name('fraud.create');
    Route::post('/frauds/store', [App\Http\Controllers\Frontend\FraudController::class, 'store'])->name('fraud.store');
    Route::post('/comment', [App\Http\Controllers\Frontend\FraudController::class, 'comment'])->name('fraud.comment');
});
