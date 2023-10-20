<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/home', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/usermanagement', [UserController::class, 'index'])->name('index');
        Route::get('/createuser', [UserController::class, 'create'])->name('create');
        Route::post('/createuser', [UserController::class, 'store'])->name('store');
        Route::get('/edituser/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/edituser/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/deleteuser/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});
