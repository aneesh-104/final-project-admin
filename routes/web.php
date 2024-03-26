<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', [App\Http\Controllers\AdminController::class, 'index']);
Route::post('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('login');
Route::get('/dashboard',  [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::put('/approve/{id}', [App\Http\Controllers\DashboardController::class, 'approve'])->name('approve');
Route::put('/deny/{id}', [App\Http\Controllers\DashboardController::class, 'deny'])->name('deny');
