<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(){
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

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
            "pharmacist" => "pharmacist.dashboard",
        ];

        if (!isset($routes[$user->role])) {
            Auth::logout();

            return redirect("/login")->withErrors([
                "email" => "Your account has an invalid role.",
            ]);
        }

        return redirect()->intended(route($routes[$user->role]));
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/login");
    }
}
