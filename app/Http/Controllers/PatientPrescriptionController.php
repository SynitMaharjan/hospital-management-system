<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PatientPrescriptionController extends Controller
{
    /**
     * Display a listing of prescriptions for the authenticated patient.
     */
    public function index(Request $request)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            abort(403, 'Patient profile not found.');
        }

        $prescriptions = $patient->prescriptions()
            ->with(['doctor.user', 'medicalRecord'])
            ->latest('prescription_date')
            ->paginate(10)
            ->withQueryString();

        return view('patient.prescription.index', compact('prescriptions'));
    }

    /**
     * Display the specified prescription.
     */
    public function show(Prescription $prescription)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient profile not found.');
        }

        // Ensure the prescription belongs to the authenticated patient
        if ($prescription->patient_id !== $patient->id) {
            abort(403, 'Unauthorized.');
        }

        $prescription->load(['doctor.user', 'medicalRecord.appointment', 'items']);

        $previousPrescriptions = $patient->prescriptions()
            ->where('id', '!=', $prescription->id)
            ->latest('prescription_date')
            ->get();

        return view('patient.prescription.show', compact('prescription', 'previousPrescriptions'));
    }
}