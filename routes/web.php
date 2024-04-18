<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\AuthenticateWithApi;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;

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
        Route::post('/updateUser/{id}', [UserController::class, 'update'])->name('updateUser');
        Route::get('/user/users/create', [UserController::class, 'create'])->name('createUser');
        Route::post('/user/users/store', [UserController::class, 'storeUser'])->name('storeUser');
        
        Route::get('//getCustomer', [CustomerController::class, 'getCustomers'])->name('getCustomer');
        Route::get('/account/customers/create', [CustomerController::class, 'create'])->name('createCustomer');
        Route::post('/account/customers/store', [CustomerController::class, 'storeCustomer'])->name('storeCustomer');
        Route::get('/editCustomer/{id}', [CustomerController::class, 'edit'])->name('editCustomer');
        Route::post('/updateCustomer/{id}', [CustomerController::class, 'update'])->name('updateCustomer');
        
        Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

        Route::get('/about', [AboutController::class, 'show'])->name('about');
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'contact'])->name('contact');

    });
});