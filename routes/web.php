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

    
    Route::resource('employees', App\Http\Controllers\Admin\Employees\EmployeeController::class);
    Route::get('employees/{id}/profile', [App\Http\Controllers\Admin\Employees\EmployeeController::class,'getProfile'])->name('employee.profile');
    Route::put('employees/{id}/profile', [App\Http\Controllers\Admin\Employees\EmployeeController::class,'updateProfile'])->name('employee.profile.update');
    Route::resource('roles', App\Http\Controllers\Admin\Roles\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\Permissions\PermissionController::class);

});
