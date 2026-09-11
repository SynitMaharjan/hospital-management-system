<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Patient;
use App\Models\User;
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
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => Role::PATIENT,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'phone' => $data['phone'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
            ]);

            return $user;
        });
    }
}
