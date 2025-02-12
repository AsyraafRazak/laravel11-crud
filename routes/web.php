<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

use  App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserRegistrationController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\AdminDashboardController;
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

Route::resource('/', EmployeeController::class);

Route::resource("/employee",EmployeeController::class);

// User  Authentication Routes
Route::get('/login', [UserLoginController::class, 'index'])->name('login')->middleware('clear_cookies');;
Route::post('/check', [UserLoginController::class, 'check'])->name('check');
Route::get('/register', [UserRegistrationController::class, 'create'])->name('register');
Route::post('/register', [UserRegistrationController::class, 'store'])->name('user.register');
//middleware implementation
Route::middleware(['auth', 'user'])->group(function () {
Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
Route::post('/logout', [UserLoginController::class, 'logout'])->name('user.logout')->middleware('clear_cookies');
});
// Admin Authentication Routes
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin.login')->middleware('clear_cookies');;
Route::post('/admin/check', [AdminLoginController::class, 'admincheck'])->name('admin.check');
Route::get('/admin/register', [AdminRegistrationController::class, 'create'])->name('admin.register');
Route::post('/admin/register', [AdminRegistrationController::class, 'store'])->name('admin.store');
Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout')->middleware('clear_cookies');
});