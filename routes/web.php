<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\AuthenticateWithApi;
use App\Http\Middleware\BreadcrumbMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    if (session()->has('api_token')) {
        return redirect()->route('account.account');
    } else {
        return view('account.account');
    }
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/create-account', [RegisterController::class, 'register'])->name('register');
Route::post('/create', [RegisterController::class, 'create'])->name('create');
Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::get('/menu', function () {
    return view('includes.menu');
})->name('menu');
Route::get('/getSubcategories/{id}', [MenuController::class, 'getSubcategories']);

Route::middleware(['web', BreadcrumbMiddleware::class])->group(function () {

    Route::middleware([AuthenticateWithApi::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::get('/account', [AccountController::class, 'account'])->name('account');
        Route::get('/deleteAddress', [AccountController::class, 'deleteAddress'])->name('deleteAddress');
        Route::post('/addAddress', [AccountController::class, 'addAddress'])->name('addAddress');
        Route::post('/editCustomer/{id}', [AccountController::class, 'editCustomer'])->name('editCustomer');
        Route::post('/editPassword', [AccountController::class, 'editPassword'])->name('editPassword');

        Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');        

        Route::get('/about', [AboutController::class, 'show'])->name('about');
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'contact'])->name('contact');

    });
});

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!login|register|menu|about|contact|create-account|account|cart|search)[\w-]+$')
    ->name('page.show');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('/add_to_cart', [ProductController::class, 'addToCart'])->name('add_to_cart');
Route::post('/remove_product_cart', [CartController::class, 'removeToCart'])->name('remove_product_cart');
Route::post('/update_quantity_cart', [CartController::class, 'updateToCart'])->name('update_quantity_cart');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');