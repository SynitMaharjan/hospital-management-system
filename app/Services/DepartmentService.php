<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\Cache;
use App\Services\AuditLogService;

class DepartmentService
{
    public function __construct(
        private AuditLogService $auditLogService
    ){}

    public function createDepartment(array $data): Department
    {
        $department = Department::create($data);
      
        $this->auditLogService->log(
            'created',
            "Created department {$department->name}"
        );  

        $this->clearDepartmentCache();

        return $department;
    }

    public function updateDepartment(
        Department $department,
        array $data
    ): Department {
        $department->update($data);

        $this->auditLogService->log(
            'updated',
            "Updated department {$department->name}"
        );

        $this->clearDepartmentCache();

        return $department;
    }

    public function deleteDepartment(
        Department $department
    ): void {
        $department->delete();

        $this->auditLogService->log(
            'deleted',
            "Deleted department {$department->name}"
        );

        $this->clearDepartmentCache();
    }

    public function getAllDepartments()
    {
        return Cache::remember(
            "departments",
            3600,
            function () {
                return Department::orderBy("name")->get();
            }
        );
    }

    private function clearDepartmentCache(): void
    {
        Cache::forget("departments");
    }
}

