<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\AuthenticateWithApi;
use App\Http\Middleware\BreadcrumbMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    if (session()->has('api_token')) {
        return redirect()->route('dashboard');
    } else {
        return view('home');
    }
});

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['web', BreadcrumbMiddleware::class])->group(function () {

    Route::middleware([AuthenticateWithApi::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');        

        Route::get('/about', [AboutController::class, 'show'])->name('about');
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'contact'])->name('contact');

    });
});
