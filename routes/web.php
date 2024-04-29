<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\AuthenticateWithApi;
use App\Http\Middleware\BreadcrumbMiddleware;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ListProductController;

Route::get('/', function () {
    return redirect('/login');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['web', BreadcrumbMiddleware::class])->group(function () {
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
        Route::post('/user/deleteUser', [UserController::class, 'deleteUser'])->name('deleteUser');
        
        Route::get('/getCustomer', [CustomerController::class, 'getCustomers'])->name('getCustomer');
        Route::get('/account/customers/create', [CustomerController::class, 'create'])->name('createCustomer');
        Route::post('/account/customers/store', [CustomerController::class, 'storeCustomer'])->name('storeCustomer');
        Route::get('/editCustomer/{id}', [CustomerController::class, 'edit'])->name('editCustomer');
        Route::post('/updateCustomer/{id}', [CustomerController::class, 'update'])->name('updateCustomer');
        Route::post('/account/deleteAddress', [CustomerController::class, 'deleteAddress'])->name('deleteAddress');
        Route::post('/account/deleteCustomer', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

        Route::get('/getCategory', [CategoryController::class, 'getCategory'])->name('getCategory');
        Route::get('/product/categories/create', [CategoryController::class, 'create'])->name('createCategories');
        Route::post('/product/categories/store', [CategoryController::class, 'storeCategory'])->name('storeCategory');
        Route::get('/editCategory/{id}', [CategoryController::class, 'edit'])->name('editCategory');
        Route::post('/updateCategory/{id}', [CategoryController::class, 'update'])->name('updateCategory');
        Route::post('/product/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');

        Route::get('/getBrand', [BrandController::class, 'getBrand'])->name('getBrand');
        Route::get('/product/brands/create', [BrandController::class, 'create'])->name('createBrands');
        Route::post('/product/brands/store', [BrandController::class, 'storeBrand'])->name('storeBrand');
        Route::get('/editBrand/{id}', [BrandController::class, 'edit'])->name('editBrand');
        Route::post('/updateBrand/{id}', [BrandController::class, 'update'])->name('updateBrand');
        Route::post('/product/deleteBrand', [BrandController::class, 'deleteBrand'])->name('deleteBrand');

        Route::get('/getProduct', [ProductController::class, 'getProduct'])->name('getProduct');
        Route::get('/product/products/create', [ProductController::class, 'create'])->name('createProducts');
        Route::post('/product/products/store', [ProductController::class, 'storeProduct'])->name('storeProduct');
        Route::get('/editProduct/{id}', [ProductController::class, 'edit'])->name('editProduct');
        Route::post('/updateProduct/{id}', [ProductController::class, 'update'])->name('updateProduct');
        Route::post('/product/deleteProduct', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
        Route::post('/product/deleteStock', [ProductController::class, 'deleteStock'])->name('deleteStock');
        Route::post('/product/addStock', [ProductController::class, 'addStock'])->name('addStock');
        Route::post('/product/addProductImages',[ProductController::class, 'addProductImages'] )->name('addProductImages');
        Route::post('/product/deleteImage', [ProductController::class, 'deleteImage'])->name('deleteImage');

        Route::get('/getListProduct', [ListProductController::class, 'getListProduct'])->name('getListProduct');
        Route::get('/editListProduct/{id}', [ListProductController::class, 'edit'])->name('editListProduct');
        Route::post('/updateListProduct/{id}', [ListProductController::class, 'update'])->name('updateListProduct');
        Route::get('/product/listProduct/create', [ListProductController::class, 'create'])->name('createListProducts');
        Route::post('/product/listProduct/store', [ListProductController::class, 'storeListProducts'])->name('storeListProducts');
        Route::post('/product/deleteListProduct', [ListProductController::class, 'deleteListProduct'])->name('deleteListProduct');

        Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

        Route::get('/about', [AboutController::class, 'show'])->name('about');
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'contact'])->name('contact');

    });
});