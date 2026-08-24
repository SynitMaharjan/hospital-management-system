<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
Route::middleware(['auth', 'doctor'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', function () {
        return view('doctor.dashboard');
    })->name('doctor.dashboard');
});
Route::middleware(['auth', 'patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
});
Route::middleware(['auth', 'nurse'])->prefix('nurse')->group(function () {
    Route::get('/dashboard', function () {
        return view('nurse.dashboard');
    })->name('nurse.dashboard');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->middleware('guest')->name('login');
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});
