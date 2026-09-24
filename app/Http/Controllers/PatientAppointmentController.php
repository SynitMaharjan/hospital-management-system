<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientAppointmentRequest;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected AppointmentService $appointmentService)
    {
    }

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
        $departments = Department::orderBy('name')->get();

        $doctors = Doctor::with(['user', 'department'])
            ->orderBy('id')
            ->get();

        return view('patient.appointment.create', compact('departments', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientAppointmentRequest $request)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, "Patient profile not found.");
        }

        $data = $request->validated();
        $data['patient_id'] = $patient->id;
        $data['status'] = 'pending'; // default status

        $appointment = $this->appointmentService->create($data);

        return redirect()
            ->route('patient.appointment.index')
            ->with('success', 'Appointment booked successfully. Your appointment is pending confirmation.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, "Patient profile not found.");
        }

        $appointment = Appointment::with("doctor.user", "doctor.department")
            ->where("patient_id", $patient->id)
            ->findOrFail($id);

        return view("patient.appointment.show", compact("appointment"));
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