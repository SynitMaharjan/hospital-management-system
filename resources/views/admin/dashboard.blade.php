@extends("layouts.dashboard")

@section("page-title")
Admin Dashboard
@endsection

@section("dashboard-content")

{{-- Statistics --}}
<div class="row g-4">

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Total Staff</p>
                        <h4 class="fw-semibold mb-0">{{ $totalStaff }}</h4>
                    </div>

                    <div class="text-primary">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Doctors</p>
                        <h4 class="fw-semibold mb-0">{{ $totalDoctors }}</h4>
                    </div>

                    <div class="text-success">
                        <i class="fa-solid fa-user-doctor fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Nurses</p>
                        <h4 class="fw-semibold mb-0">{{ $totalNurses }}</h4>
                    </div>

                    <div class="text-info">
                        <i class="fa-solid fa-user-nurse fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Receptionists</p>
                        <h4 class="fw-semibold mb-0">{{ $totalReceptionists }}</h4>
                    </div>

                    <div class="text-warning">
                        <i class="fa-solid fa-headset fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- Patients --}}
<div class="row g-4 mt-1">

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Registered Patients</p>
                        <h4 class="fw-semibold mb-0">{{ $totalPatients }}</h4>
                    </div>

                    <div class="text-secondary">
                        <i class="fa-solid fa-hospital-user fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- Staff Management --}}
<div class="mt-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">

        <div>
            <h5 class="fw-semibold mb-1">
                Staff Management
            </h5>

            <p class="text-muted small mb-0">
                Manage hospital staff accounts and roles.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route("admin.staff.index") }}"
               class="btn btn-outline-primary">

                <i class="fa-solid fa-users me-1"></i>
                View Staff

            </a>

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

    </div>

    @include("admin.staff.modals.create-from")

</div>


{{-- Recent Activity --}}
<div class="mt-5">

    <div class="mb-3">
        <h5 class="fw-semibold mb-1">
            Recent Activity
        </h5>

        <p class="text-muted small mb-0">
            Latest actions recorded in the system.
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        @forelse($recentAuditLogs as $log)

            <div class="px-4 py-3 border-bottom">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div class="min-width-0">

                        <div class="fw-medium">
                            {{ ucfirst($log->action) }} staff account
                        </div>

                        <div class="text-muted small mt-1">
                            {{ $log->description }}
                        </div>

                        <div class="text-muted small mt-2">
                            By
                            <span class="fw-medium text-dark">
                                {{ $log->user?->name ?? "System" }}
                            </span>
                        </div>

                    </div>

                    <div class="text-end flex-shrink-0">

                        <span class="badge text-bg-secondary">
                            {{ ucfirst($log->action) }}
                        </span>

                        <div class="text-muted small mt-1">
                            {{ $log->created_at->diffForHumans() }}
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center text-muted py-5">
                <i class="fa-regular fa-clock mb-2"></i>

                <div>
                    No recent activity.
                </div>
            </div>

        @endforelse

        <div class="text-end px-4 py-3">

            <a href="{{ route("audit-log.index") }}"
               class="btn btn-sm btn-outline-primary">

                View all activity
                <i class="fa-solid fa-arrow-right ms-1"></i>

            </a>

        </div>

    </div>

</div>


@vite("resources/js/staff.js")

@endsection
