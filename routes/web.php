<?php

use App\Http\Controllers\ExternalUserController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

/* This code defines a route for the URL path "/dmiesys". When a user visits this URL, the function
inside the `get` method is executed. In this case, the function redirects the user to the route
named "dashboard". */

Route::get('/dmiesys', function () {
    return redirect()->route('dashboard');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/external-user', ExternalUserController::class);
