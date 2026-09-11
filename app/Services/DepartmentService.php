<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\Cache;

class DepartmentService
{
    public function createDepartment(array $data): Department
    {
        $department = Department::create($data);

        $this->clearDepartmentCache();

        return $department;
    }

    public function updateDepartment(
        Department $department,
        array $data
    ): Department {
        $department->update($data);

        $this->clearDepartmentCache();

        return $department;
    }

    public function deleteDepartment(
        Department $department
    ): void {
        $department->delete();

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

