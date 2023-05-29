<?php

use App\Http\Controllers\ExternalUser\StudentProfileController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Middleware\HomeRedirect;
use Illuminate\Support\Facades\Route;

/* This code defines a route for the URL path "/dmiesys". When a user visits this URL, the function
inside the `get` method is executed. In this case, the function redirects the user to the route
named "dashboard". */

Route::get('/dmiesys', function () {
    return redirect()->route('dashboard');
});

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(HomeRedirect::class);

Route::get('/student-login', [StudentProfileController::class, 'login'])->name('student.login');
Route::get('/student-login/{token}/edit', [StudentProfileController::class, 'login']);
Route::resource('/student-profile', StudentProfileController::class);
