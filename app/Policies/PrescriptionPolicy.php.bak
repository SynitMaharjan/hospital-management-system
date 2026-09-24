<?php

namespace App\Policies;

use App\Models\Prescription;
use App\Models\User;

class PrescriptionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === \App\Enums\Role::DOCTOR
            && $user->doctor !== null;
    }

    public function view(User $user, Prescription $prescription): bool
    {
        if (!$user->doctor) {
            return false;
        }

        return $prescription->doctor_id === $user->doctor->id;
    }

    public function create(User $user): bool
    {
        return $user->role === \App\Enums\Role::DOCTOR
            && $user->doctor !== null;
    }

    public function update(User $user, Prescription $prescription): bool
    {
        if (!$user->doctor) {
            return false;
        }

        return $prescription->doctor_id === $user->doctor->id;
    }

    public function delete(
        User $user,
        Prescription $prescription
    ): bool {
        return false;
    }
}

