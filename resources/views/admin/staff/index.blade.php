@extends("layouts.dashboard")

@section("page-title")
    Staff Management
@endsection

@section("dashboard-content")
<div id="staff-page"
    data-validation-errors="{{ $errors->any() ? 'true' : 'false' }}"
> 
<div
    id="staff-created"
    data-created="{{ session('created_staff') ? 'true' : 'false' }}"
></div>

    {{-- Create Staff Modal --}}
    @include("admin.staff.modals.create-from")

    {{-- Staff Created / Credentials Modal --}}
    @include("admin.staff.modals.created")


    <div class="container-fluid px-0">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-semibold mb-1">
                    Staff Management
                </h2>

                <p class="text-muted mb-0">
                    Manage hospital staff accounts
                </p>

            </div>


            <!-- Create Staff Button -->
            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createStaffModal"
            >
                <i class="fa-solid fa-user-plus me-1"></i>
                Create Staff
            </button>

        </div>


        <!-- Success Message -->
        @if(session("success"))

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session("success") }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

            </div>

        @endif


        <!-- Staff Table Card -->
        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <!-- Responsive Table -->
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-4 py-3 text-nowrap">
                                    Name
                                </th>

                                <th class="py-3 text-nowrap">
                                    Username
                                </th>

                                <th class="py-3 text-nowrap">
                                    Employee ID
                                </th>

                                <th class="py-3 text-nowrap">
                                    Email
                                </th>

                                <th class="py-3 text-nowrap">
                                    Role
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

                            @forelse($staff as $member)

                                <tr>

                                    <!-- Name -->
                                    <td class="px-4 text-nowrap">

                                        <div class="fw-medium">
                                            {{ $member->name }}
                                        </div>

                                    </td>


                                    <!-- Username -->
                                    <td class="text-nowrap">
                                        {{ $member->username }}
                                    </td>


                                    <!-- Employee ID -->
                                    <td class="text-nowrap">

                                        <span class="font-monospace">
                                            {{ $member->employee_id }}
                                        </span>

                                    </td>


                                    <!-- Email -->
                                    <td class="text-nowrap">
                                        {{ $member->email }}
                                    </td>


                                    <!-- Role -->
                                    <td class="text-nowrap">

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($member->role->value) }}
                                        </span>

                                    </td>


                                    <!-- Created -->
                                    <td class="text-nowrap">

                                        {{ $member->created_at->format("M d, Y") }}

                                    </td>


                                    <!-- Actions -->
                                    <td class="text-nowrap">

                                        <!-- View -->
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewStaffModal{{ $member->id }}"
                                            title="View Staff"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </button>


                                        <!-- Edit -->
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStaffModal{{ $member->id }}"
                                            title="Edit Staff"
                                        >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>


                                        <!-- Delete -->
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteStaffModal{{ $member->id }}"
                                            title="Delete Staff"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </td>

                                </tr>


                                <!-- Staff Modals -->
                                @include("admin.staff.modals.view")
                                @include("admin.staff.modals.edit")
                                @include("admin.staff.modals.delete")


                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center py-5 text-muted"
                                    >

                                        <div class="mb-2">
                                            <i class="fa-solid fa-users fa-2x"></i>
                                        </div>

                                        <div>
                                            No staff accounts found.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- Pagination -->
                @if($staff->hasPages())

                    <div class="p-3 border-top">

                        {{ $staff->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>
</div>

@vite("resources/js/staff.js")

@endsection