<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Enums\Role;

class AuthController extends Controller
{
    public function showLogin(){
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $login = $data["login"];
        $credentials = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? [
                "email" => $login,
                "password" => $data["password"],
            ]
            : [
                "username" => $login,
                "password" => $data["password"],
            ];

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                "login" => "Invalid username/email or password.",
            ])->withInput();
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

        if (!isset($routes[$user->role->value])) {
            Auth::logout();

            return redirect("/login")->withErrors([
                "login" => "Your account has an invalid role.",
            ]);
        }

        return redirect()->intended(route($routes[$user->role->value]));
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
            "username" => $data['username'],
            "email" => $data['email'],
            "password" => Hash::make($data['password']),
            "role" => Role::PATIENT, 
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
