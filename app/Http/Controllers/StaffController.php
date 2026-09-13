<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\User;
use App\Services\StaffService;
use App\Services\DepartmentService;

class StaffController extends Controller
{
    public function __construct(
        private StaffService $staffService,
        private DepartmentService $departmentService
        
    ) {}

    public function index()
    {
        $query = User::whereIn("role", [
            Role::DOCTOR->value,
            Role::NURSE->value,
            Role::RECEPTIONIST->value,
        ]);

        // Search
        if (request("search")) {
            $search = request("search");

            $query->where(function ($q) use ($search) {
                $q->where("name", "ilike", "%{$search}%")
                    ->orWhere("username", "ilike", "%{$search}%")
                    ->orWhere("email", "ilike", "%{$search}%")
                    ->orWhere("employee_id", "ilike", "%{$search}%");
            });
        }

        // Role filter
        if (request("role")) {
            $query->where("role", request("role"));
        }
                // Department filter
        if (request("department")) {

        $departmentId = request("department");

        $query->where(function ($q) use ($departmentId) {

            $q->whereHas("doctor", function ($q) use ($departmentId) {
                $q->where("department_id", $departmentId);
            })

            ->orWhereHas("nurse", function ($q) use ($departmentId) {
                $q->where("department_id", $departmentId);
            });

        });

        }


        $staff = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $departments = $this->departmentService->getAllDepartments();

        return view("admin.staff.index", compact(
            "staff",
            "departments"
        ));
    }

    public function create()
    {
        $departments = $this->departmentService->getAllDepartments();

        return view("admin.staff.create", compact("departments"));
    }

    public function store(StoreStaffRequest $request)
    {
        $staff = $this->staffService->createStaff(
            $request->validated()
        );

        return redirect()
            ->route("admin.staff.index")
            ->with("created_staff", $staff);
    }

    public function show(User $staff)
    {
        return view("admin.staff.show", compact("staff"));
    }

    public function edit(User $staff)
    {
        return view("admin.staff.edit", compact("staff"));
    }

    public function update(
        UpdateStaffRequest $request,
        User $staff
    ) {
        $this->staffService->updateStaff(
            $staff,
            $request->validated()
        );

        return redirect()
            ->route("admin.staff.index")
            ->with(
                "success",
                "Staff updated successfully."
            );
    }

    public function destroy(User $staff)
    {
        $this->staffService->deleteStaff($staff);

        return redirect()
            ->route("admin.staff.index")
            ->with(
                "success",
                "Staff deleted successfully."
            );
    }
}
