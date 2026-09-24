<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorPatientController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $query = Patient::whereHas('appointments', function ($q) use ($doctor) {
            $q->where('doctor_id', $doctor->id);
        })
        ->with([
            'user',
            'latestAppointment' => function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            },
        ])
        ->withCount([
            'appointments as visit_count' => function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            },
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'ilike', "%{$search}%")
                    ->orWhere('last_name', 'ilike', "%{$search}%")
                    ->orWhere('patient_number', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhereRaw( "CONCAT_WS(' ', first_name, middle_name, last_name) ILIKE ?", ["%{$search}%"] );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Ordering & Pagination
        |--------------------------------------------------------------------------
        */

        $patients = $query
            ->orderByDesc('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view('doctor.patient.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        |
        | A doctor can only access patients who have had an appointment
        | with that doctor.
        |
        */

        $hasAppointment = $patient->appointments()
            ->where('doctor_id', $doctor->id)
            ->exists();

        if (!$hasAppointment) {
            abort(403, "You do not have access to this patient's records.");
        }

        /*
        |--------------------------------------------------------------------------
        | Patient Information
        |--------------------------------------------------------------------------
        */

        $patient->load([
            'user',
            'appointments' => function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id)
                    ->with('doctor.department')
                    ->latest('appointment_date')
                    ->latest('appointment_time');
            },
        ]);

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $doctorAppointments = $patient->appointments()
            ->where('doctor_id', $doctor->id);

        $stats = [
            'total_visits' => (clone $doctorAppointments)->count(),

            'completed_visits' => (clone $doctorAppointments)
                ->where('status', 'completed')
                ->count(),

            'last_visit' => (clone $doctorAppointments)
                ->latest('appointment_date')
                ->latest('appointment_time')
                ->first(),

            'first_visit' => (clone $doctorAppointments)
                ->oldest('appointment_date')
                ->oldest('appointment_time')
                ->first(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Recent Appointments
        |--------------------------------------------------------------------------
        */

        $recentAppointments = $patient->appointments
            ->sortByDesc(function ($appointment) {
                return $appointment->appointment_date->format('Y-m-d')
                    . ' '
                    . $appointment->appointment_time->format('H:i');
            })
            ->take(10);

        /*
        |--------------------------------------------------------------------------
        | Upcoming Appointments
        |--------------------------------------------------------------------------
        */

        $upcomingAppointments = $patient->appointments
            ->filter(function ($appointment) {
                return $appointment->appointment_date->isToday()
                    || $appointment->appointment_date->isFuture();
            })
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->sortBy(function ($appointment) {
                return $appointment->appointment_date->format('Y-m-d')
                    . ' '
                    . $appointment->appointment_time->format('H:i');
            });

        return view(
            'doctor.patient.show',
            compact(
                'patient',
                'stats',
                'recentAppointments',
                'upcomingAppointments'
            )
        );
    }
}