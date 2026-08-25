<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showLogin(){
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                "email" => "Invalid credentials.",
                "password" => "Password incorrect.",
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        $routes = [
            "admin" => "admin.dashboard",
            "patient" => "patient.dashboard",
            "doctor" => "doctor.dashboard",
            "nurse" => "nurse.dashboard",
            "receptionist" => "receptionist.dashboard",
        ];

        if (!isset($routes[$user->role])) {
            Auth::logout();

            return redirect("/login")->withErrors([
                "email" => "Your account has an invalid role.",
            ]);
        }

        return redirect()->intended(route($routes[$user->role]));
    }
    public function showRegister()
    {
        return view("auth.register");
    }
    public function register(RegisterRequest $request)
    {
        $data =$request->validated();

        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data['password']),
            "role" => "patient", 
        ]);

        Auth::login($user);

        return redirect()->route("patient.dashboard");
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/login");
    }
}
