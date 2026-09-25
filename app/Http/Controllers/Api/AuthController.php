<?php

namespace App\Http\Controllers\Api;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $result = DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => trim(
                    $validated['first_name'] . ' ' .
                    ($validated['middle_name'] ?? '') . ' ' .
                    $validated['last_name']
                ),
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => Role::PATIENT,
            ]);

            $patient = Patient::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'blood_group' => $validated['blood_group'] ?? null,
            ]);

            return [
                'user' => $user,
                'patient' => $patient,
            ];
        });

        $token = $result['user']
            ->createToken('api-token')
            ->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful.',
            'user' => $result['user'],
            'patient' => $result['patient'],
            'token' => $token,
        ], 201);
    }
}