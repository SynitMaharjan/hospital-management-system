<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class MedicalRecordService
{
    /**
     * Get medical records for a specific doctor with search and filters.
     */
    public function getDoctorMedicalRecords(
        Doctor $doctor,
        Request $request
    ): LengthAwarePaginator {
        $query = MedicalRecord::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'appointment'])
            ->latest('record_date');

        // Filter by patient.
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Search patient and medical record information.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($pq) use ($search) {
                    $pq->where('first_name', 'ilike', "%{$search}%")
                        ->orWhere('last_name', 'ilike', "%{$search}%")
                        ->orWhere('patient_number', 'ilike', "%{$search}%")
                        ->orWhere('phone', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                })
                ->orWhere('diagnosis', 'ilike', "%{$search}%")
                ->orWhere('chief_complaint', 'ilike', "%{$search}%")
                ->orWhereRaw( "CONCAT_WS(' ', first_name, middle_name, last_name) ILIKE ?", ["%{$search}%"] );
            });
        }

        // Date filter.
        if ($request->filled('date_from')) {
            $query->where(
                'record_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->where(
                'record_date',
                '<=',
                $request->date_to
            );
        }

        return $query
            ->paginate(15)
            ->withQueryString();
    }

    /**
     * Get medical records for a specific patient belonging to a doctor.
     */
    public function getPatientMedicalRecords(
        Doctor $doctor,
        Patient $patient
    ): Collection {
        return MedicalRecord::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->with(['appointment'])
            ->latest('record_date')
            ->get();
    }

    /**
     * Get appointments available for creating a medical record.
     */
    public function getAvailableAppointments(
        Doctor $doctor
    ): Collection {
        return Appointment::where('doctor_id', $doctor->id)
            ->whereDoesntHave('medicalRecord')
            ->with(['patient.user'])
            ->latest('appointment_date', 'appointment_time')
            ->get();
    }

    /**
     * Create a medical record.
     */
    public function createMedicalRecord(array $data): MedicalRecord
    {
        return MedicalRecord::create($data);
    }
}