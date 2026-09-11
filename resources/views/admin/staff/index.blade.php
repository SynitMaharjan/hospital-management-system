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

       
        {{-- Search & Filters --}}

        <form
            method="GET"
            action="{{ route('admin.staff.index') }}"
            class="d-flex flex-wrap align-items-center gap-2 mb-4"
        >

            {{-- Search --}}
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
                    placeholder="Search staff..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
            </div>


            {{-- Filter Dropdown --}}
            <div class="dropdown">

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="Filter"
                >
                    <i class="fa-solid fa-filter me-1"></i>
                    Filter
                </button>


                <div
                    class="dropdown-menu p-3 shadow-sm border-0"
                    style="min-width: 240px;"
                >

                    <div class="fw-semibold mb-2">
                        Filter Staff
                    </div>

                    <label
                        for="role"
                        class="form-label small text-muted mb-1"
                    >
                        Role
                    </label>

                    <select
                        name="role"
                        id="role"
                        class="form-select form-select-sm"
                    >

                        <option value="">
                            All Roles
                        </option>

                        <option
                            value="doctor"
                            {{ request('role') === 'doctor' ? 'selected' : '' }}
                        >
                            Doctor
                        </option>

                        <option
                            value="nurse"
                            {{ request('role') === 'nurse' ? 'selected' : '' }}
                        >
                            Nurse
                        </option>

                        <option
                            value="receptionist"
                            {{ request('role') === 'receptionist' ? 'selected' : '' }}
                        >
                            Receptionist
                        </option>

                    </select>

                        <label
                            for="department"
                            class="form-label small text-muted mb-1 mt-3"

                        >
                            Department
                       </label>

                        <select
                            name="department"
                            id="department"
                            class="form-select form-select-sm"

                        >


                        <option value="">
                            All Departments
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                {{ request('department') == $department->id ? 'selected' : '' }}
                            >
                                {{ $department->name }}
                            </option>

                            @endforeach
                    

                        </select>


                </div>

            </div>


            {{-- Search Button --}}
            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="fa-solid fa-magnifying-glass me-1"></i>
                Search
            </button>


            {{-- Clear --}}
            @if(request()->hasAny(['search', 'role', 'department']))

                <a
                    href="{{ route('admin.staff.index') }}"
                    class="btn btn-outline-secondary"
                    title="Clear search and filters"
                >
                    <i class="fa-solid fa-xmark me-1"></i>
                    Clear
                </a>

            @endif

        </form>

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