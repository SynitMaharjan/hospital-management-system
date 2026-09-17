<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        $todayAppointments = Appointment::with(
            'patient.user',
            'doctor.user',
            'doctor.department'
        )
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();

        $appointmentStats = [
            'today' => $todayAppointments->count(),

            'pending' => $todayAppointments
                ->where('status', 'pending')
                ->count(),

            'confirmed' => $todayAppointments
                ->where('status', 'confirmed')
                ->count(),

            'completed' => $todayAppointments
                ->where('status', 'completed')
                ->count(),
        ];

        return view(
            'receptionist.dashboard',
            compact('todayAppointments', 'appointmentStats')
        );
    }
}