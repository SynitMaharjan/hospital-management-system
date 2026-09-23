<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\ExistingPatientOtpNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
    
class AuthService
{
    /**
     * Authenticate a user using email or username.
     */
    public function login(array $data): ?User
    {
        $login = $data['login'];

        $credentials = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? [
                'email' => $login,
                'password' => $data['password'],
            ]
            : [
                'username' => $login,
                'password' => $data['password'],
            ];

        if (!Auth::attempt($credentials)) {
            return null;
        }

        return Auth::user();
    }

    /**
     * Get the dashboard route for a user's role.
     */
    public function dashboardRoute(User $user): ?string
    {
        $routes = [
            'admin' => 'admin.dashboard',
            'patient' => 'patient.dashboard',
            'doctor' => 'doctor.dashboard',
            'nurse' => 'nurse.dashboard',
            'receptionist' => 'receptionist.dashboard',
        ];

        return $routes[$user->role->value] ?? null;
    }

    /**
     * Register a new patient and create their patient profile.
     */
    public function registerPatient(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => Role::PATIENT,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'blood_group' => $data['blood_group'] ?? null,
            ]);

            return $user;
        });
    }

    /**
     * Find an existing patient using their patient number and email.
     */
    public function findExistingPatient(array $data): ?Patient
    {
        return Patient::where('patient_number', $data['patient_number'])
            ->where('email', $data['email'])
            ->first();
    }

    /**
     * Generate and send an OTP for an existing patient.
     */
    public function sendExistingPatientOtp(Patient $patient): void
    {
        $otp = (string) random_int(100000, 999999);

        $patient->verifications()->create([
            'email' => $patient->email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        $patient->notify(
            new ExistingPatientOtpNotification($patient, $otp)
        );
    }
       
    public function createExistingPatientAccount(
        Patient $patient,
        array $data
    ): User {
        return DB::transaction(function () use ($patient, $data) {

            $user = User::create([
                'name' => $patient->fullName,
                'username' => $data['username'],
                'email' => $patient->email,
                'password' => Hash::make($data['password']),
                'role' => 'patient',
            ]);

            $patient->update([
                'user_id' => $user->id,
            ]);

            return $user;
        });
    }
}