<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    /**
     * Determine whether the user can view any medical records.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === \App\Enums\Role::DOCTOR
            && $user->doctor !== null;
    }

    /**
     * Determine whether the user can view the medical record.
     */
    public function view(
        User $user,
        MedicalRecord $medicalRecord
    ): bool {
        if (!$user->doctor) {
            return false;
        }

        return $medicalRecord->doctor_id === $user->doctor->id;
    }

    /**
     * Determine whether the user can create medical records.
     */
    public function create(User $user): bool
    {
        return $user->role === \App\Enums\Role::DOCTOR
            && $user->doctor !== null;
    }

    /**
     * Determine whether the user can update the medical record.
     */
    public function update(
        User $user,
        MedicalRecord $medicalRecord
    ): bool {
        if (!$user->doctor) {
            return false;
        }

        return $medicalRecord->doctor_id === $user->doctor->id;
    }

    /**
     * Determine whether the user can delete the medical record.
     */
    public function delete(
        User $user,
        MedicalRecord $medicalRecord
    ): bool {
        return false;
    }
}

