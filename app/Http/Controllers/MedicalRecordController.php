<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function __construct(
        protected MedicalRecordService $medicalRecordService
    ) {}

    /**
     * Display a listing of medical records for the authenticated doctor.
     */
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('viewAny', MedicalRecord::class);

        $medicalRecords = $this->medicalRecordService
            ->getDoctorMedicalRecords($doctor, $request);

        return view(
            'doctor.medical-record.index',
            compact('medicalRecords')
        );
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('create', MedicalRecord::class);

        $appointments = $this->medicalRecordService
            ->getAvailableAppointments($doctor);

        return view(
            'doctor.medical-record.create',
            compact('appointments')
        );
    }

    /**
     * Store a newly created medical record.
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('create', MedicalRecord::class);

        $appointment = $doctor->appointments()
            ->whereDoesntHave('medicalRecord')
            ->findOrFail($request->appointment_id);

        $data = $request->validated();

        $data['doctor_id'] = $doctor->id;
        $data['patient_id'] = $appointment->patient_id;
        $data['appointment_id'] = $appointment->id;

        $medicalRecord = $this->medicalRecordService
            ->createMedicalRecord($data);

        return redirect()
            ->route('doctor.medical-record.show', $medicalRecord)
            ->with('success', 'Medical record created successfully.');
    }

    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('view', $medicalRecord);

        $medicalRecord->load([
            'patient.user',
            'doctor.user',
            'appointment',
            'prescriptions.items',
        ]);

        $previousRecords = $this->medicalRecordService
            ->getPatientMedicalRecords(
                $doctor,
                $medicalRecord->patient
            )
            ->reject(
                fn ($record) => $record->id === $medicalRecord->id
            );

        return view(
            'doctor.medical-record.show',
            compact('medicalRecord', 'previousRecords')
        );
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('update', $medicalRecord);

        return view(
            'doctor.medical-record.edit',
            compact('medicalRecord')
        );
    }

    /**
     * Update the specified medical record.
     */
    public function update(
        UpdateMedicalRecordRequest $request,
        MedicalRecord $medicalRecord
    ) {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('update', $medicalRecord);

        $medicalRecord->update($request->validated());

        return redirect()
            ->route('doctor.medical-record.show', $medicalRecord)
            ->with('success', 'Medical record updated successfully.');
    }
}