<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Services\AppointmentService;

class DoctorAppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $appointmentService
    ) {
    }

    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, "Doctor profile not found.");
        }

        $appointments = Appointment::with("patient.user")
            ->where("doctor_id", $doctor->id)

            // Search by appointment number or patient name
            ->when($request->filled("search"), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where("appointment_number", "ILIKE", "%{$search}%")
                        ->orWhereHas("patient", function ($patientQuery) use ($search) {
                            $patientQuery
                                ->where("first_name", "ILIKE", "%{$search}%")
                                ->orWhere("middle_name", "ILIKE", "%{$search}%")
                                ->orWhere("last_name", "ILIKE", "%{$search}%");
                        });
                });
            })

            // Filter by appointment status
            ->when($request->filled("status"), function ($query) use ($request) {
                $query->where("status", $request->status);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statuses = AppointmentStatus::cases();

        return view(
            "doctor.appointment.index",
            compact("appointments", "statuses")
        );
    }

    public function show(string $id)
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, "Doctor profile not found.");
        }

        $appointment = Appointment::with("patient.user")
            ->where("doctor_id", $doctor->id)
            ->findOrFail($id);

        return view("doctor.appointment.show", compact("appointment"));
    }

    public function update(Request $request, string $id)
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, "Doctor profile not found.");
        }

        $appointment = Appointment::where("doctor_id", $doctor->id)
            ->findOrFail($id);

        $validated = $request->validate([
            "status" => "required|in:confirmed,cancelled,completed",
        ]);

        $this->appointmentService->updateStatus(
            $appointment,
            $validated["status"]
        );

        return response()->json([
            "message" => "Appointment marked as completed successfully.",
            "status" => "success",
        ]);
    }
}

