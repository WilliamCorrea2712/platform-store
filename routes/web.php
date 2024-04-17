<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\AuthenticateWithApi;
use App\Http\Controllers\UserController;

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['web'])->group(function () {
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
            return view('dashboard');
        })->name('dashboard');

        Route::get('/getUser', [UserController::class, 'getUsers'])->name('getUser');
        Route::get('/editUser/{id}', [UserController::class, 'edit'])->name('editUser');
        Route::get('/users/create', [UserController::class, 'create'])->name('createUser');
        Route::post('/users/store', [UserController::class, 'storeUser'])->name('storeUser');
        Route::post('/updateUser/{id}', [UserController::class, 'update'])->name('updateUser');
        Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    });
});