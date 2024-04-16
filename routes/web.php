<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\AuthenticateWithApi;
use App\Http\Controllers\UserController;

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware([
    'web',
])->group(function () {
    Route::get('/', function () {
        if (session()->has('api_token')) {
            return redirect()->route('dashboard');
        } else {
            return Inertia::render('Welcome', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
            ]);
        }
    });

    Route::middleware([AuthenticateWithApi::class])->group(function () {
        Route::get('/dashboard', function () {
            //return Inertia::render('Dashboard');
            return view('dashboard');
        })->name('dashboard');
    });

    Route::middleware(['web'])->group(function () {
        Route::get('/editUser', [UserController::class, 'edit'])->name('editUser');
    });
});
