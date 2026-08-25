<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AdminController;
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
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::resource('staff', StaffController::class)
            ->names('admin.staff');
    });
Route::middleware(['auth', 'doctor', 'must.change.password'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', function () {
        return view('doctor.dashboard');
    })->name('doctor.dashboard');
});
Route::middleware(['auth', 'patient', 'must.change.password'])->prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
});
Route::middleware(['auth', 'nurse', 'must.change.password'])->prefix('nurse')->group(function () {
    Route::get('/dashboard', function () {
        return view('nurse.dashboard');
    })->name('nurse.dashboard');
});
Route::middleware(['auth', 'receptionist', 'must.change.password'])->prefix('receptionist')->group(function () {
    Route::get('/dashboard', function () {
        return view('receptionist.dashboard');
    })->name('receptionist.dashboard');
});
Route::middleware("auth")->group(function () {
    Route::get("/change-password", [PasswordController::class, "edit"])
        ->name("password.change");

    Route::post("/change-password", [PasswordController::class, "update"])
        ->name("password.update");
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->middleware('guest')->name('login');
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
    Route::get('/register', 'showRegister')->middleware('guest')->name('register');
    Route::post('/register', 'register')->middleware('guest');
});

Route::get('/', function () {
    return view('welcome');
});
