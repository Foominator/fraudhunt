<?php

use Illuminate\Support\Facades\Route;

Route::get('/советы', [App\Http\Controllers\Frontend\MainController::class, 'advices'])->name('advices');
