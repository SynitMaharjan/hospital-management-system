<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
     public function edit()
    {
        return view("auth.change-password");
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            "password" => "required|string|min:8|max:20|confirmed",
        ]);

        $user = $request->user();

        $user->update([
            "password" => Hash::make($validated["password"]),
            "must_change_password" => false,
        ]);

        return redirect()->intended(
            route($user->role->value . ".dashboard")
        );
    }
}
