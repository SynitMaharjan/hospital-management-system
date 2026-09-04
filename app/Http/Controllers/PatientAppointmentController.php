<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class PatientAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
            $patient = auth()->user()->patient;

            if (!$patient) {
                abort(403, "Patient profile not found.");
            }

            $appointments = Appointment::with("doctor.user", "doctor.department")
                ->where("patient_id", $patient->id)
                ->latest()
                ->paginate(10);

            return view("patient.appointment.index", compact("appointments"));
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
    public function store(Request $request)
    {
        //
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
