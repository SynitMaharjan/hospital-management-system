<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;

class ReceptionistPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Patient::query();

        // Search
        if (request('search')) {

            $search = request('search');

            $query->where(function ($q) use ($search) {

                $q->where('patient_number', 'ilike', "%{$search}%")
                    ->orWhere('first_name', 'ilike', "%{$search}%")
                    ->orWhere('last_name', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhereRaw( "CONCAT_WS(' ', first_name, middle_name, last_name) ILIKE ?", ["%{$search}%"] );

            });
        }

        // Gender filter
        if (request('gender')) {

            $query->where(
                'gender',
                request('gender')
            );
        }

        $patients = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'receptionist.patient.index',
            compact('patients')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $validated = $request->validated();

        Patient::create($validated);

        return redirect()
            ->route('receptionist.patient.index')
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $validated = $request->validated();

        $patient->update($validated);

        return redirect()
            ->route('receptionist.patient.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('receptionist.patient.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
