<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Http\Requests\StoreAppointmentRequest;
use App\Notifications\AppointmentCreatedNotification;

class ReceptionistAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $appointments = Appointment::with("patient.user", "doctor.user")
            ->latest()
            ->paginate(10);

        $patients = Patient::with("user")->get();

        $doctors = Doctor::with("user")->get();

        return view(
            "receptionist.appointment.index",
            compact("appointments", "patients", "doctors")
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $validated = $request->validated();

        $alreadyBooked = Appointment::where("doctor_id", $validated["doctor_id"])
            ->where("appointment_date", $validated["appointment_date"])
            ->where("appointment_time", $validated["appointment_time"])
            ->whereIn("status", ["pending", "confirmed"])
            ->exists();

        if ($alreadyBooked) {
            return back()
                ->withInput()
                ->withErrors([
                    "appointment_time" =>
                        "The doctor already has an appointment at this date and time.",
                ]);
        }

        $appointment = Appointment::create($validated);
        $appointment->load('patient.user', 'doctor.user');

        // Notify the doctor via email
        if ($appointment->doctor && $appointment->doctor->user) {
            $appointment->doctor->user->notify(
                new AppointmentCreatedNotification($appointment)
            );
        }

        return redirect()
            ->route("receptionist.appointment.index")
            ->with("success", "Appointment created successfully. Doctor has been notified.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}