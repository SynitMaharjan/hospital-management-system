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
use App\Services\AuditLogService;

class StaffService
{
    public function __construct(
        private AuditLogService $audit_log_service
    ) {}
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

            $this->audit_log_service->log(
                'created',
                "Created {$data['role']} account for {$staff->name}"
            );

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

        $this->audit_log_service->log(
            'updated',
            "Updated staff account for {$staff->name}"
        );

        Cache::forget("admin_dashboard_stats");
    }

   public function deleteStaff(User $staff): void
    {
        $staffName = $staff->name;
        $staffRole = $staff->role->value;

        DB::transaction(function () use ($staff, $staffName, $staffRole) {

            if ($staffRole === Role::DOCTOR->value) {

                Doctor::where(
                    "user_id",
                    $staff->id
                )->delete();

            } elseif ($staffRole === Role::NURSE->value) {

                Nurse::where(
                    "user_id",
                    $staff->id
                )->delete();
            }

            $staff->delete();

            $this->audit_log_service->log(
                'deleted',
                "Deleted {$staffRole} account for {$staffName}"
            );
        });

        Cache::forget("admin_dashboard_stats");
    }
}
