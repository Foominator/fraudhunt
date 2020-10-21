<?php

use Illuminate\Support\Facades\Route;

Route::get('/поради', [App\Http\Controllers\Frontend\MainController::class, 'advices'])->name('advices');
