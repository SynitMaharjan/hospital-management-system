<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    /**
     * Show the patient dashboard.
     */
    public function index(Request $request)
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            abort(403, 'Patient profile not found.');
        }

        // Upcoming appointment (next pending or confirmed appointment)
        $upcomingAppointment = Appointment::with(['doctor.user', 'doctor.department'])
            ->where('patient_id', $patient->id)
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();

        // Recent medical record (most recent)
        $recentMedicalRecord = $patient->medicalRecords()
            ->with(['doctor.user'])
            ->latest('record_date')
            ->first();

        // Recent prescription (most recent)
        $recentPrescription = $patient->prescriptions()
            ->with(['doctor.user', 'medicalRecord.appointment'])
            ->latest('prescription_date')
            ->first();

        return view('patient.dashboard', compact(
            'patient',
            'upcomingAppointment',
            'recentMedicalRecord',
            'recentPrescription'
        ));
    }
}