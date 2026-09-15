<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        private DepartmentService $departmentService
    ) {}

    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $query = Department::query();

        if ($request->filled("search")) {

            $search = $request->search;

            $query->where(function ($query) use ($search) {

                $query->where(
                    "name",
                    "ilike",
                    "%{$search}%"
                )->orWhere(
                    "description",
                    "ilike",
                    "%{$search}%"
                );

            });
        }

        $departments = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            "admin.department.index",
            compact("departments")
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.department.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->createDepartment(
            $request->validated()
        );

        return redirect()
            ->route("admin.department.index")
            ->with(
                "success",
                "Department created successfully."
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view(
            "admin.department.show",
            compact("department")
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view(
            "admin.department.edit",
            compact("department")
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateDepartmentRequest $request,
        Department $department
    ) {
        $this->departmentService->updateDepartment(
            $department,
            $request->validated()
        );

        return redirect()
            ->route("admin.department.index")
            ->with(
                "success",
                "Department updated successfully."
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->departmentService->deleteDepartment(
            $department
        );

        return redirect()
            ->route("admin.department.index")
            ->with(
                "success",
                "Department deleted successfully."
            );
    }
}
