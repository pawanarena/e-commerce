<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Admin routes
 */
Route::controller(LoginController::class)->group(function () {
    Route::get('admin/login', 'showLoginForm')->name('admin.login');
    Route::post('admin/login', 'login')->name('admin.login');
    Route::get('admin/logout', 'logout')->name('admin.logout');
});

// Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard']);

Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.' ], function () {
    Route::get('/', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('dashboard');
    /* Employees Roles and Permission */
    Route::resource('employees', App\Http\Controllers\Admin\Employees\EmployeeController::class);
    Route::get('employees/{id}/profile', [App\Http\Controllers\Admin\Employees\EmployeeController::class,'getProfile'])->name('employee.profile');
    Route::put('employees/{id}/profile', [App\Http\Controllers\Admin\Employees\EmployeeController::class,'updateProfile'])->name('employee.profile.update');
    Route::resource('roles', App\Http\Controllers\Admin\Roles\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\Permissions\PermissionController::class);
    /* Categories */
    Route::resource('categories', App\Http\Controllers\Admin\Categories\CategoryController::class);
    Route::get('remove-image-category', [App\Http\Controllers\Admin\Categories\CategoryController::class,'removeImage'])->name('category.remove.image');
    /* Attributes */
    Route::resource('attributes',  App\Http\Controllers\Admin\Attributes\AttributeController::class);
    Route::resource('attributes.values', App\Http\Controllers\Admin\Attributes\AttributeValueController::class);
     /* Brands */
    Route::resource('brands', App\Http\Controllers\Admin\Brands\BrandController::class);
    /* Product */
    Route::resource('products', App\Http\Controllers\Admin\Products\ProductController::class);
    Route::controller(App\Http\Controllers\Admin\Products\ProductController::class)->group(function () {
        Route::get('remove-image-product', 'removeImage')->name('product.remove.image');
        Route::get('remove-image-thumb', 'removeThumbnail')->name('product.remove.thumb');
    });

});

Route::get('/', function () {
    return view('welcome');
})->name('home');
