<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $doctor = $user->doctor; // Assuming the User has a doctor relationship

        // Today's appointments
        $today = now()->startOfDay();
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $today)
            ->with('patient.user')
            ->orderBy('appointment_time')
            ->get();

        // Upcoming appointments (excluding today)
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', $today)
            ->with('patient.user')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // Recent patients (patients the doctor has seen recently)
        $recentPatients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id)
                ->whereNotNull('appointment_date'); // or any condition for completed appointments
        })->with(['user', 'appointments' => function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id)
                ->latest('appointment_date');
        }])
        ->take(5)
        ->get();

        // Stats
        $totalPatients = Patient::whereHas('appointments', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->distinct()->count();

        $todaysAppointmentCount = $todayAppointments->count();
        $upcomingAppointmentCount = $upcomingAppointments->count();
        $completedTodayCount = $todayAppointments->where('status', 'completed')->count();

        // This week appointments (Monday to Sunday)
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $thisWeekCount = Appointment::where('doctor_id', $doctor->id)
            ->whereBetween('appointment_date', [$weekStart, $weekEnd])
            ->count();

        // Pending appointments (not completed or cancelled)
        $pendingCount = $todayAppointments->whereNotIn('status', ['completed', 'cancelled'])->count();

        return view('doctor.dashboard', [
            'doctor' => $doctor,
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'recentPatients' => $recentPatients,
            'totalPatients' => $totalPatients,
            'todaysAppointmentCount' => $todaysAppointmentCount,
            'upcomingAppointmentCount' => $upcomingAppointmentCount,
            'completedTodayCount' => $completedTodayCount,
            'thisWeekCount' => $thisWeekCount,
            'pendingCount' => $pendingCount,
        ]);
    }
}