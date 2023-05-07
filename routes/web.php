<?php

use App\Http\Controllers\ExternalUserController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::resource('/external-user', ExternalUserController::class);
