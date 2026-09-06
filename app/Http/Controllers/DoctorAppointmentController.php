<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

use App\Notifications\AppointmentStatusUpdatedNotification;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            abort(403, "Doctor profile not found.");
        }

        $appointments = Appointment::with("patient.user")
            ->where("doctor_id", $doctor->id)
            ->latest()
            ->paginate(10);

        return view("doctor.appointment.index", compact("appointments"));
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
            "status" => "required|in:confirmed,cancelled",
        ]);

        $appointment->update([
            "status" => $validated["status"],
        ]);

        $appointment->load("patient.user", "doctor.user");

        $appointment->patient->user->notify(
            new AppointmentStatusUpdatedNotification($appointment)
        );

        return redirect()
            ->route("doctor.appointment.show", $appointment->id)
            ->with("success", "Appointment status updated successfully.");
        }
    }
