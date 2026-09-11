<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login(
            $request->validated()
        );

        if (!$user) {
            return back()
                ->withErrors([
                    'login' => 'Invalid username/email or password.',
                ])
                ->withInput();
        }

        $request->session()->regenerate();

        $dashboardRoute = $this->authService->dashboardRoute($user);

        if (!$dashboardRoute) {
            Auth::logout();

            return redirect('/login')->withErrors([
                'login' => 'Your account has an invalid role.',
            ]);
        }

        return redirect()->intended(
            route($dashboardRoute)
        );
    }

    public function showRegister()
    {
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
