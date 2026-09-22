<?php

namespace App\Services;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PrescriptionService
{
    /**
     * Get prescriptions for a specific doctor with search and filters.
     */
    public function getDoctorPrescriptions(
        Doctor $doctor,
        Request $request
    ): LengthAwarePaginator {
        $query = Prescription::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'medicalRecord', 'items'])
            ->latest('prescription_date');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($pq) use ($search) {
                    $pq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('patient_number', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })
                ->orWhere('prescription_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where(
                'prescription_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->where(
                'prescription_date',
                '<=',
                $request->date_to
            );
        }

        return $query
            ->paginate(15)
            ->withQueryString();
    }

    /**
     * Get prescriptions for a specific patient.
     */
    public function getPatientPrescriptions(
        Doctor $doctor,
        Patient $patient
    ): Collection {
        return Prescription::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->with(['medicalRecord', 'items'])
            ->latest('prescription_date')
            ->get();
    }

    /**
     * Get medical records available for creating a prescription.
     */
    public function getAvailableMedicalRecords(
        Doctor $doctor
    ): Collection {
        return MedicalRecord::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'appointment'])
            ->latest('record_date')
            ->get();
    }

    /**
     * Get a specific medical record belonging to the doctor.
     */
    public function getDoctorMedicalRecord(
        Doctor $doctor,
        int $medicalRecordId
    ): ?MedicalRecord {
        return MedicalRecord::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'appointment'])
            ->find($medicalRecordId);
    }

    /**
     * Create a prescription with items in a transaction.
     */
    public function createPrescription(
        Doctor $doctor,
        int $medicalRecordId,
        array $data,
        array $items
    ): Prescription {
        return DB::transaction(function () use (
            $doctor,
            $medicalRecordId,
            $data,
            $items
        ) {
            $medicalRecord = MedicalRecord::where('doctor_id', $doctor->id)
                ->findOrFail($medicalRecordId);

            $nextId = DB::selectOne(
                "SELECT nextval('prescriptions_id_seq') AS id"
            )->id;

            $data['id'] = $nextId;
            $data['prescription_number'] = 'RX-' . str_pad(
                $nextId,
                5,
                '0',
                STR_PAD_LEFT
            );

            $data['medical_record_id'] = $medicalRecord->id;
            $data['patient_id'] = $medicalRecord->patient_id;
            $data['doctor_id'] = $doctor->id;

            $prescription = Prescription::create($data);

            foreach ($items as $index => $item) {
                $item['prescription_id'] = $prescription->id;
                $item['sort_order'] = $index;

                PrescriptionItem::create($item);
            }

            return $prescription->load('items');
        });
    }
}
