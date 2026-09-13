@extends("layouts.dashboard")

@section("page-title")
    Admin Dashboard
@endsection

@section("dashboard-content")

    <!-- Statistics -->
    <div class="row g-4">

        <!-- Total Staff -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Total Staff
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $totalStaff }}
                    </h3>

                </div>
            </div>
        </div>


        <!-- Doctors -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Doctors
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $totalDoctors }}
                    </h3>

                </div>
            </div>
        </div>


        <!-- Nurses -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Nurses
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $totalNurses }}
                    </h3>

                </div>
            </div>
        </div>


        <!-- Receptionists -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Receptionists
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $totalReceptionists }}
                    </h3>

                </div>
            </div>
        </div>

    </div>


    <!-- Patients -->
    <div class="row mt-4">

        <div class="col-xl-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Registered Patients
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $totalPatients }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    <!-- Staff Management -->
    <div class="mt-5">

        <div class="mb-3">

            <h5 class="fw-semibold mb-1">
                Staff Management
            </h5>

            <p class="text-muted mb-0">
                Manage doctors, nurses, receptionists, and other hospital staff.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route("admin.staff.index") }}"
               class="btn btn-primary">
               <i class="fa-solid fa-eye"></i>
                View All Staff
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
            @include("admin.staff.modals.create-from")

        </div>

    </div>
    <!-- Recent Activity -->

    <div class="mt-5">

        <div class="mb-3">
            <h5 class="fw-semibold mb-1">
                Recent Activity
            </h5>

            <p class="text-muted mb-0">
                Recent actions performed in the hospital system.
            </p>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">
           
            @forelse($recentAuditLogs as $log)

                <div class="d-flex align-items-center justify-content-between
                            px-4 py-3 border-bottom">

                    <div>

                        <div class="fw-semibold">
                            {{ ucfirst($log->action) }} staff account
                        </div>

                        <div class="text-muted small">
                            {{ $log->description }}
                        </div>

                        <div class="small mt-1">
                            By <span class="fw-medium">
                                {{ $log->user?->name ?? 'System' }}
                            </span>
                        </div>

                    </div>

                    <div class="text-end">

                        <span class="badge text-bg-secondary">
                            {{ ucfirst($log->action) }}
                        </span>

                        <div class="small text-muted mt-1">
                            {{ $log->created_at->diffForHumans() }}
                        </div>

                    </div>

                </div>



                @empty

                    <div class="text-center text-muted py-4">
                        No recent activity.
                    </div>

            @endforelse

            </div>

        </div>
       <div class="text-end p-3 border-top">
            <a href="{{ route("audit-log.index") }}"
            class="btn btn-sm btn-outline-primary">

                View all activity
                <i class="fa-solid fa-arrow-right ms-1"></i>

            </a>
        </div>

    </div>
    @vite("resources/js/staff.js")

@endsection