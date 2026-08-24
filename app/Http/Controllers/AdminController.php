<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStaff = User::whereIn("role", [
            "doctor",
            "nurse",
            "receptionist",
        ])->count();

        $totalDoctors = User::where("role", "doctor")->count();

        $totalNurses = User::where("role", "nurse")->count();

        $totalReceptionists = User::where("role", "receptionist")->count();

        $totalPatients = User::where("role", "patient")->count();

        return view("admin.dashboard", compact(
            "totalStaff",
            "totalDoctors",
            "totalNurses",
            "totalReceptionists",
            "totalPatients"
        ));
    }
}