<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class PatientMedicalRecordController extends Controller
{
    /**
     * Display a listing of medical records for the authenticated patient.
     */
    public function index(Request $request)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            abort(403, 'Patient profile not found.');
        }

        $medicalRecords = $patient->medicalRecords()
            ->with(['doctor.user'])
            ->latest('record_date')
            ->paginate(10)
            ->withQueryString();

        return view('patient.medical-record.index', compact('medicalRecords'));
    }

    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            abort(403, 'Patient profile not found.');
        }

        // Ensure the medical record belongs to the authenticated patient
        if ($medicalRecord->patient_id !== $patient->id) {
            abort(403, 'Unauthorized.');
        }

        $medicalRecord->load(['doctor.user', 'appointment', 'prescriptions.items']);

        $previousRecords = $patient->medicalRecords()
            ->where('id', '!=', $medicalRecord->id)
            ->latest('record_date')
            ->get();

        return view('patient.medical-record.show', compact('medicalRecord', 'previousRecords'));
    }
}