<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffService
{
    public function createStaff(array $data): array
    {
        $temporaryPassword = Str::password(12);

        $staff = DB::transaction(function () use ($data, $temporaryPassword) {

            $staff = User::create([
                "name" => $data["name"],
                "username" => $data["username"],
                "employee_id" => $data["employee_id"],
                "email" => $data["email"],
                "password" => Hash::make($temporaryPassword),
                "role" => $data["role"],
                "must_change_password" => true,
            ]);

            if ($data["role"] === Role::DOCTOR->value) {

                Doctor::create([
                    "user_id" => $staff->id,
                    "department_id" => $data["department_id"],
                    "specialization" => $data["specialization"],
                    "license_number" => $data["license_number"],
                    "phone" => $data["phone"],
                ]);

            } elseif ($data["role"] === Role::NURSE->value) {

                Nurse::create([
                    "user_id" => $staff->id,
                    "department_id" => $data["department_id"],
                    "phone" => $data["phone"],
                ]);
            }

            return $staff;
        });

        Cache::forget("admin_dashboard_stats");

        return [
            "name" => $staff->name,
            "employee_id" => $staff->employee_id,
            "role" => $staff->role,
            "username" => $staff->username,
            "temporary_password" => $temporaryPassword,
        ];
    }

    public function updateStaff(User $staff, array $data): void
    {
        DB::transaction(function () use ($data, $staff) {

            $oldRole = $staff->role->value;
            $newRole = $data["role"];

            $staff->update([
                "name" => $data["name"],
                "username" => $data["username"],
                "employee_id" => $data["employee_id"],
                "email" => $data["email"],
                "role" => $newRole,
            ]);

            if ($newRole === Role::DOCTOR->value) {

                Doctor::updateOrCreate(
                    [
                        "user_id" => $staff->id,
                    ],
                    [
                        "department_id" => $data["department_id"],
                        "specialization" => $data["specialization"],
                        "license_number" => $data["license_number"],
                        "phone" => $data["phone"],
                    ]
                );

                if ($oldRole === Role::NURSE->value) {
                    Nurse::where(
                        "user_id",
                        $staff->id
                    )->delete();
                }

            } elseif ($newRole === Role::NURSE->value) {

                Nurse::updateOrCreate(
                    [
                        "user_id" => $staff->id,
                    ],
                    [
                        "department_id" => $data["department_id"],
                        "phone" => $data["phone"],
                    ]
                );

                if ($oldRole === Role::DOCTOR->value) {
                    Doctor::where(
                        "user_id",
                        $staff->id
                    )->delete();
                }

            } elseif ($newRole === Role::RECEPTIONIST->value) {

                if ($oldRole === Role::DOCTOR->value) {

                    Doctor::where(
                        "user_id",
                        $staff->id
                    )->delete();

                } elseif ($oldRole === Role::NURSE->value) {

                    Nurse::where(
                        "user_id",
                        $staff->id
                    )->delete();
                }
            }
        });

        Cache::forget("admin_dashboard_stats");
    }

    public function deleteStaff(User $staff): void
    {
        $staff->delete();

        Cache::forget("admin_dashboard_stats");
    }
}
