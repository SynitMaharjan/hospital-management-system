<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExistingPatientRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\CreatePatientAccountRequest;
use App\Services\AuthService;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = $this->authService->login($credentials);

        if (!$user) {
            return back()
                ->withErrors([
                    'login' => 'The provided credentials are incorrect.',
                ])
                ->withInput($request->only('login'));
        }

        $request->session()->regenerate();

        $route = $this->authService->dashboardRoute($user);

        if (!$route) {
            Auth::logout();

            return back()->withErrors([
                'login' => 'Your account does not have a valid role.',
            ]);
        }

        return redirect()->route($route);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegister(Request $request)
    {
        $type = $request->query('type');

        if ($type === 'new') {
            return view('auth.register-new');
        }

        if ($type === 'existing') {
            return view('auth.register-existing');
        }

        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->registerPatient(
            $request->validated()
        );

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('patient.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Existing Patient Registration
    |--------------------------------------------------------------------------
    */

    public function existingPatient(ExistingPatientRequest $request)
    {
        $patient = $this->authService->findExistingPatient(
            $request->validated()
        );

        if (!$patient) {
            return back()
                ->withErrors([
                    'patient_number' =>
                        'The patient number and email do not match our records.',
                ])
                ->withInput();
        }

        if ($patient->user_id) {
            return back()
                ->withErrors([
                    'patient_number' =>
                        'This patient already has an account. Please log in instead.',
                ])
                ->withInput();
        }

        $this->authService->sendExistingPatientOtp($patient);

        session([
            'existing_patient_id' => $patient->id,
        ]);

        return redirect()->route('register.existing.verify');
    }

    public function showExistingPatientVerify()
    {
        if (!session('existing_patient_id')) {
            return redirect()->route('register');
        }

        return view('auth.verify-existing-patient');
    }

    public function verifyExistingPatient(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $patientId = session('existing_patient_id');

        if (!$patientId) {
            return redirect()->route('register');
        }

        $patient = Patient::find($patientId);

        if (!$patient) {
            session()->forget([
                'existing_patient_id',
                'existing_patient_verified',
            ]);

            return redirect()->route('register');
        }

        $verification = $patient->verifications()
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$verification) {
            return back()->withErrors([
                'otp' =>
                    'No valid verification code was found. Please request a new code.',
            ]);
        }

        if ($verification->expires_at->isPast()) {
            return back()->withErrors([
                'otp' =>
                    'This verification code has expired. Please request a new code.',
            ]);
        }

        if (!Hash::check($request->otp, $verification->otp_hash)) {
            return back()
                ->withErrors([
                    'otp' =>
                        'The verification code is incorrect.',
                ])
                ->withInput();
        }

        $verification->update([
            'verified_at' => now(),
        ]);

        session([
            'existing_patient_verified' => true,
        ]);

        return redirect()->route('register.existing.account');
    }

    public function restartExistingPatientRegistration()
    {
        session()->forget([
            'existing_patient_id',
            'existing_patient_verified',
        ]);

        return redirect()->route('register', [
            'type' => 'existing',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Existing Patient Account Creation
    |--------------------------------------------------------------------------
    */

    public function showExistingPatientAccount()
    {
        if (!session('existing_patient_id')) {
            return redirect()->route('register');
        }

        if (!session('existing_patient_verified')) {
            return redirect()->route('register.existing.verify');
        }

        return view('auth.create-existing-account');
    }

    public function createExistingPatientAccount(
        CreatePatientAccountRequest $request
    ) {
        $patientId = session('existing_patient_id');

        if (!$patientId) {
            return redirect()->route('register');
        }

        if (!session('existing_patient_verified')) {
            return redirect()->route('register.existing.verify');
        }

        $patient = Patient::find($patientId);

        if (!$patient) {
            session()->forget([
                'existing_patient_id',
                'existing_patient_verified',
            ]);

            return redirect()->route('register');
        }

        if ($patient->user_id) {
            session()->forget([
                'existing_patient_id',
                'existing_patient_verified',
            ]);

            return redirect()->route('login')
                ->withErrors([
                    'login' =>
                        'This patient already has an account. Please log in.',
                ]);
        }

        $user = $this->authService->createExistingPatientAccount(
            $patient,
            $request->validated()
        );

        Auth::login($user);

        $request->session()->regenerate();

        session()->forget([
            'existing_patient_id',
            'existing_patient_verified',
        ]);

        return redirect()->route('patient.dashboard');
    }
}
