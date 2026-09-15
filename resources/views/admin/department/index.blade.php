@extends("layouts.dashboard")

@section("page-title")
Departments
@endsection

@section("dashboard-content")

@include("admin.department.modals.create")

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-semibold mb-1">
                Department Management
            </h2>

            <p class="text-muted mb-0">
                Manage hospital departments
            </p>
        </div>


        <!-- Create Department Button -->
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createDepartmentModal"
        >
            <i class="fa-solid fa-plus me-1"></i>
            Create Department
        </button>

    </div>


    <!-- Success Message -->
    @if(session("success"))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            {{ session("success") }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    <!-- Search -->
    <form
        method="GET"
        action="{{ route("admin.department.index") }}"
        class="d-flex flex-wrap align-items-center gap-2 mb-4"
    >

        <!-- Search Box -->
        <div
            class="input-group"
            style="max-width: 500px;"
        >

            <span class="input-group-text bg-white border-end-0">
                <i class="fa-solid fa-magnifying-glass text-muted"></i>
            </span>

            <input
                type="text"
                name="search"
                class="form-control border-start-0 ps-0"
                placeholder="Search departments..."
                value="{{ request("search") }}"
                autocomplete="off"
            >

        </div>


        <!-- Search Button -->
        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-magnifying-glass me-1"></i>
            Search
        </button>


        <!-- Clear Button -->
        @if(request()->filled("search"))

            <a
                href="{{ route("admin.department.index") }}"
                class="btn btn-outline-secondary"
                title="Clear search"
            >
                <i class="fa-solid fa-xmark me-1"></i>
                Clear
            </a>

        @endif

    </form>


    <!-- Department Table Card -->
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <!-- Responsive Table -->
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4 py-3 text-nowrap">
                                ID
                            </th>

                            <th class="py-3 text-nowrap">
                                Name
                            </th>

                            <th class="py-3">
                                Description
                            </th>

                            <th class="py-3 text-nowrap">
                                Created
                            </th>

                            <th class="py-3 text-nowrap">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($departments as $department)

                            <tr>

                                <!-- ID -->
                                <td class="px-4 text-nowrap">

                                    <span class="font-monospace">
                                        {{ $department->id }}
                                    </span>

                                </td>


                                <!-- Name -->
                                <td class="text-nowrap">

                                    <div class="fw-medium">
                                        {{ $department->name }}
                                    </div>

                                </td>


                                <!-- Description -->
                                <td>

                                    <span class="text-muted">
                                        {{ $department->description ?? "No description" }}
                                    </span>

                                </td>


                                <!-- Created -->
                                <td class="text-nowrap">

                                    {{ $department->created_at->format("M d, Y") }}

                                </td>


                                <!-- Actions -->
                                <td class="text-nowrap">

                                    <!-- View Button -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewDepartmentModal{{ $department->id }}"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </button>


                                    <!-- Edit Button -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editDepartmentModal{{ $department->id }}"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>


                                    <!-- Delete Button -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteDepartmentModal{{ $department->id }}"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </td>

                            </tr>


                            <!-- View Department Modal -->
                            @include("admin.department.modals.view")


                            <!-- Edit Department Modal -->
                            @include("admin.department.modals.edit")


                            <!-- Delete Department Modal -->
                            @include("admin.department.modals.delete")


                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5 text-muted"
                                >
                                    No departments found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- Pagination -->
            @if($departments->hasPages())

                <div class="p-3 border-top">

                    {{ $departments->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection