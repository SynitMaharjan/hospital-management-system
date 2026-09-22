<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Models\Prescription;
use App\Services\PrescriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function __construct(
        protected PrescriptionService $prescriptionService
    ) {}

    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('viewAny', Prescription::class);

        $prescriptions = $this->prescriptionService
            ->getDoctorPrescriptions($doctor, $request);

        return view(
            'doctor.prescription.index',
            compact('prescriptions')
        );
    }

    public function create(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('create', Prescription::class);

        $medicalRecords = $this->prescriptionService
            ->getAvailableMedicalRecords($doctor);

        $selectedMedicalRecord = null;

        if ($request->filled('medical_record_id')) {
            $selectedMedicalRecord = $this->prescriptionService
                ->getDoctorMedicalRecord(
                    $doctor,
                    (int) $request->medical_record_id
                );
        }

        return view(
            'doctor.prescription.create',
            compact(
                'medicalRecords',
                'selectedMedicalRecord'
            )
        );
    }

    public function store(StorePrescriptionRequest $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('create', Prescription::class);

        $data = $request->validated();

        $items = $data['items'];
        unset($data['items']);

        $prescription = $this->prescriptionService
            ->createPrescription(
                $doctor,
                $data['medical_record_id'],
                $data,
                $items
            );

        return redirect()
            ->route('doctor.prescription.show', $prescription)
            ->with('success', 'Prescription created successfully.');
    }

    public function show(Prescription $prescription)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $this->authorize('view', $prescription);

        $prescription->load([
            'patient.user',
            'doctor.user',
            'medicalRecord.appointment',
            'items',
        ]);

        return view(
            'doctor.prescription.show',
            compact('prescription')
        );
    }
}

