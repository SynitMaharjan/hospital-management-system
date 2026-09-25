<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\ReceptionistAppointmentController;
use App\Http\Controllers\ReceptionistPatientController;
use App\Http\Controllers\ReceptionistCheckInController;
use App\Http\Controllers\ReceptionistBillController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorPatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientMedicalRecordController;
use App\Http\Controllers\PatientPrescriptionController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditLogController;

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

// FOR ADMIN
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::resource('staff', StaffController::class)
            ->names('admin.staff');

        Route::resource('patient', PatientController::class)
            ->only('index')
            ->names('admin.patient');

        Route::resource('appointment', AppointmentController::class)
            ->names('admin.appointment');

        Route::resource('department', DepartmentController::class)
            ->names('admin.department');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])
            ->name('audit-log.index');
    });


// FOR DOCTOR
Route::middleware(['auth', 'doctor', 'must.change.password'])
    ->prefix('doctor')
    ->group(function () {

        Route::get('/dashboard', [DoctorController::class, 'dashboard'])
            ->name('doctor.dashboard');

        Route::resource('appointment', DoctorAppointmentController::class)
            ->only(['index', 'show', 'update'])
            ->names('doctor.appointment');

        Route::resource('patient', DoctorPatientController::class)
            ->only(['index', 'show'])
            ->names('doctor.patient');

        Route::resource('medical-record', MedicalRecordController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update'])
            ->names('doctor.medical-record');

        Route::resource('prescription', PrescriptionController::class)
            ->only(['index', 'create', 'store', 'show'])
            ->names('doctor.prescription');
    });


// PATIENT
Route::middleware(['auth', 'patient', 'must.change.password'])
    ->prefix('patient')
    ->group(function () {


        Route::get('/dashboard', [PatientDashboardController::class, 'index'])
            ->name('patient.dashboard');
        Route::resource('appointment', PatientAppointmentController::class)
            ->only(['index', 'show', 'create', 'store'])
            ->names('patient.appointment');
        Route::resource('medical-record', PatientMedicalRecordController::class)
            ->only(['index', 'show'])
            ->names('patient.medical-record');

        Route::resource('prescription', PatientPrescriptionController::class)
            ->only(['index', 'show'])
            ->names('patient.prescription');
    });


// NURSE
Route::middleware(['auth', 'nurse', 'must.change.password'])
    ->prefix('nurse')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('nurse.dashboard');
        })->name('nurse.dashboard');
    });


// RECEPTIONIST
Route::middleware(['auth', 'receptionist', 'must.change.password'])
    ->prefix('receptionist')
    ->group(function () {

        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])
            ->name('receptionist.dashboard');


        // Patients

        Route::resource('patient', ReceptionistPatientController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names('receptionist.patient');


        // Appointments

        Route::resource('appointment', ReceptionistAppointmentController::class)
            ->names('receptionist.appointment');


        // Check-In

        Route::resource('check-in', ReceptionistCheckInController::class)
            ->only(['index', 'store'])
            ->names('receptionist.check-in');

        Route::patch(
            'check-in/{checkIn}/status',
            [ReceptionistCheckInController::class, 'updateStatus']
        )->name('receptionist.check-in.status');


        // Billing

        Route::get(
            'bill/{bill}/print',
            [ReceptionistBillController::class, 'print']
        )->name('receptionist.bill.print');
        
        Route::resource('bill', ReceptionistBillController::class)
            ->only(['index', 'store', 'show'])
            ->names('receptionist.bill');

        Route::get(
            'bill/patient/{patient}/appointments',
            [ReceptionistBillController::class, 'appointmentsByPatient']
        )->name('receptionist.bill.patient.appointments');

        Route::post(
            'bill/{bill}/item',
            [ReceptionistBillController::class, 'storeItem']
        )->name('receptionist.bill.item.store');

        Route::delete(
            'bill/{bill}/item/{item}',
            [ReceptionistBillController::class, 'destroyItem']
        )->name('receptionist.bill.item.destroy');

        Route::post(
            'bill/{bill}/payment',
            [ReceptionistBillController::class, 'payment']
        )->name('receptionist.bill.payment');
        
    });

// PASSWORD
Route::middleware('auth')
    ->group(function () {

        Route::get('/change-password', [PasswordController::class, 'edit'])
            ->name('password.change');

        Route::post('/change-password', [PasswordController::class, 'update'])
            ->name('password.update');

        Route::get('/profile', [ProfileController::class, 'show'])
            ->name('profile.show');

        Route::post('/profile', [ProfileController::class, 'update'])
            ->name('profile.picture.update');
    });


// AUTH
Route::controller(AuthController::class)
    ->group(function () {

        Route::get('/login', 'showLogin')
            ->middleware('guest')
            ->name('login');

        Route::post('/login', 'login')
            ->middleware('guest');

        Route::post('/logout', 'logout')
            ->middleware('auth')
            ->name('logout');

        Route::get('/register', 'showRegister')
            ->middleware('guest')
            ->name('register');

        Route::post('/register', 'register')
            ->middleware('guest');

        Route::post('/register/existing', 'existingPatient')
            ->middleware('guest')
            ->name('register.existing');

        Route::get('/register/existing/verify', 'showExistingPatientVerify')
            ->middleware('guest')
            ->name('register.existing.verify');

        Route::post('/register/existing/verify', 'verifyExistingPatient')
            ->middleware('guest')
            ->name('register.existing.verify.submit');

        Route::get('/register/existing/restart', 'restartExistingPatientRegistration')
            ->name('register.existing.restart');

        Route::get('/register/existing/account', 'showExistingPatientAccount')
            ->middleware('guest')
            ->name('register.existing.account');

        Route::post('/register/existing/account', 'createExistingPatientAccount')
            ->middleware('guest')
            ->name('register.existing.account.store');
    });


// HOME
Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route(
            auth()->user()->role->value . '.dashboard'
        );
    }

    return redirect()->route('login');
});