@extends('layouts.dashboard')

@section('page-title')
    Patient Overview
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-1">

                <div class="text-primary fs-4">
                    <i class="fa-solid fa-user"></i>
                </div>

                <h2 class="fw-semibold mb-0">
                    Patient Overview
                </h2>

            </div>

            <p class="text-muted mb-0">
                View patient information and clinical activity
            </p>
        </div>

        <a
            href="{{ route('doctor.patient.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Patients
        </a>

    </div>


    <!-- Patient Information -->
    <div class="row g-4 mb-4">

        <!-- Patient Profile -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="text-center">

                        <!-- Profile Picture -->
                        @if($patient->user)

                            <img
                                src="{{ $patient->user->profile_picture_url }}"
                                alt="{{ $patient->full_name }}"
                                class="rounded-circle border mb-3"
                                width="110"
                                height="110"
                                style="object-fit: cover;"
                            >

                        @else

                            <div
                                class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 110px; height: 110px;"
                            >
                                <i class="fa-solid fa-user fs-1"></i>
                            </div>

                        @endif


                        <!-- Name -->
                        <h4 class="fw-semibold mb-1">
                            {{ $patient->full_name }}
                        </h4>

                        <!-- Patient Number -->
                        <div class="text-muted small mb-3">
                            Patient #{{ $patient->patient_number }}
                        </div>


                        <!-- Patient Badges -->
                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">

                            @if($patient->date_of_birth)

                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">

                                    <i class="fa-solid fa-calendar me-1"></i>

                                    {{ $patient->date_of_birth->age }} years

                                </span>

                            @endif


                            @if($patient->gender)

                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">

                                    <i class="fa-solid fa-venus-mars me-1"></i>

                                    {{ $patient->gender->value }}

                                </span>

                            @endif


                            @if($patient->blood_group)

                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                    <i class="fa-solid fa-droplet me-1"></i>

                                    {{ $patient->blood_group->value }}

                                </span>

                            @endif

                        </div>


                        <!-- Contact Information -->
                        <div class="border-top pt-3 text-start">

                            <div class="d-flex align-items-center gap-3 mb-3">

                                <div
                                    class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 36px; height: 36px;"
                                >
                                    <i class="fa-solid fa-phone fa-sm"></i>
                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Phone
                                    </small>

                                    <span class="fw-medium">
                                        {{ $patient->phone ?? 'Not available' }}
                                    </span>

                                </div>

                            </div>


                            @if($patient->email)

                                <div class="d-flex align-items-center gap-3">

                                    <div
                                        class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width: 36px; height: 36px;"
                                    >
                                        <i class="fa-solid fa-envelope fa-sm"></i>
                                    </div>

                                    <div>

                                        <small class="text-muted d-block">
                                            Email
                                        </small>

                                        <span class="fw-medium text-break">
                                            {{ $patient->email }}
                                        </span>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Appointment Information -->
        <div class="col-lg-8">

            <div class="row g-4 h-100">

                <!-- Recent Appointments -->
                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="text-primary">
                                    <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                                </div>

                                <div>

                                    <h5 class="fw-semibold mb-0">
                                        Recent Appointments
                                    </h5>

                                    <small class="text-muted">
                                        Previous visits
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body p-0">

                            @if($recentAppointments->isEmpty())

                                <div class="text-center py-5 px-3">

                                    <div
                                        class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 60px; height: 60px;"
                                    >
                                        <i class="fa-solid fa-calendar-xmark fs-4"></i>
                                    </div>

                                    <p class="text-muted small mt-3 mb-0">
                                        No recent appointments
                                    </p>

                                </div>

                            @else

                                <div class="list-group list-group-flush">

                                    @foreach($recentAppointments->take(5) as $appointment)

                                        @php

                                            $status = $appointment->status->value;

                                            $statusClass = match ($status) {
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'confirmed' => 'primary',
                                                'pending' => 'warning',
                                                default => 'secondary',
                                            };

                                            $statusIcon = match ($status) {
                                                'completed' => 'fa-circle-check',
                                                'cancelled' => 'fa-circle-xmark',
                                                'confirmed' => 'fa-circle-check',
                                                'pending' => 'fa-clock',
                                                default => 'fa-circle-question',
                                            };

                                        @endphp

                                        <div class="list-group-item border-0 border-top py-3 px-4">

                                            <div class="d-flex justify-content-between align-items-start gap-3">

                                                <div class="min-w-0">

                                                    <div class="fw-medium text-truncate">

                                                        {{ $appointment->doctor?->department?->name ?? 'General' }}

                                                    </div>

                                                    <small class="text-muted">

                                                        <i class="fa-regular fa-calendar me-1"></i>

                                                        {{ $appointment->appointment_date->format('M d, Y') }}

                                                        <span class="mx-1">•</span>

                                                        <i class="fa-regular fa-clock me-1"></i>

                                                        {{ $appointment->appointment_time->format('g:i A') }}

                                                    </small>

                                                </div>


                                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} px-2 py-1 flex-shrink-0">

                                                    <i class="fa-solid {{ $statusIcon }} me-1"></i>

                                                    {{ ucfirst($status) }}

                                                </span>

                                            </div>


                                            @if($appointment->reason)

                                                <small class="text-muted d-block mt-2">

                                                    <i class="fa-solid fa-comment-medical me-1"></i>

                                                    {{ Str::limit($appointment->reason, 60) }}

                                                </small>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                <!-- Upcoming Appointments -->
                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="text-primary">
                                    <i class="fa-solid fa-calendar-days fs-5"></i>
                                </div>

                                <div>

                                    <h5 class="fw-semibold mb-0">
                                        Upcoming Appointments
                                    </h5>

                                    <small class="text-muted">
                                        Scheduled visits
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body p-0">

                            @if($upcomingAppointments->isEmpty())

                                <div class="text-center py-5 px-3">

                                    <div
                                        class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 60px; height: 60px;"
                                    >
                                        <i class="fa-solid fa-calendar-check fs-4"></i>
                                    </div>

                                    <p class="text-muted small mt-3 mb-0">
                                        No upcoming appointments
                                    </p>

                                </div>

                            @else

                                <div class="list-group list-group-flush">

                                    @foreach($upcomingAppointments->take(5) as $appointment)

                                        @php

                                            $status = $appointment->status->value;

                                            $statusClass = match ($status) {
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'confirmed' => 'primary',
                                                'pending' => 'warning',
                                                default => 'secondary',
                                            };

                                            $statusIcon = match ($status) {
                                                'completed' => 'fa-circle-check',
                                                'cancelled' => 'fa-circle-xmark',
                                                'confirmed' => 'fa-circle-check',
                                                'pending' => 'fa-clock',
                                                default => 'fa-circle-question',
                                            };

                                        @endphp

                                        <div class="list-group-item border-0 border-top py-3 px-4">

                                            <div class="d-flex justify-content-between align-items-start gap-3">

                                                <div class="min-w-0">

                                                    <div class="fw-medium text-truncate">

                                                        {{ $appointment->doctor?->department?->name ?? 'General' }}

                                                    </div>

                                                    <small class="text-muted">

                                                        <i class="fa-regular fa-calendar me-1"></i>

                                                        {{ $appointment->appointment_date->format('M d, Y') }}

                                                        <span class="mx-1">•</span>

                                                        <i class="fa-regular fa-clock me-1"></i>

                                                        {{ $appointment->appointment_time->format('g:i A') }}

                                                    </small>

                                                </div>


                                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} px-2 py-1 flex-shrink-0">

                                                    <i class="fa-solid {{ $statusIcon }} me-1"></i>

                                                    {{ ucfirst($status) }}

                                                </span>

                                            </div>


                                            @if($appointment->reason)

                                                <small class="text-muted d-block mt-2">

                                                    <i class="fa-solid fa-comment-medical me-1"></i>

                                                    {{ Str::limit($appointment->reason, 60) }}

                                                </small>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Quick Links -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

            <h5 class="fw-semibold mb-1">
                Clinical Records
            </h5>

            <small class="text-muted">
                Access this patient's clinical information
            </small>

        </div>


        <div class="card-body px-4 pb-4">

            <div class="row g-3">

                <!-- Medical Records -->
                <div class="col-md-4">

                    <a
                        href="{{ route('doctor.medical-record.index', ['patient_id' => $patient->id]) }}"
                        class="text-decoration-none"
                    >

                        <div class="border rounded-3 p-4 h-100">

                            <div class="d-flex align-items-start gap-3">

                                <div
                                    class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 48px; height: 48px;"
                                >
                                    <i class="fa-solid fa-file-medical fs-5"></i>
                                </div>

                                <div>

                                    <h6 class="fw-semibold text-dark mb-1">
                                        Medical Records
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        View and create clinical records
                                    </p>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>


                <!-- Prescriptions -->
                <div class="col-md-4">

                    <a
                        href="{{ route('doctor.prescription.index', ['patient_id' => $patient->id]) }}"
                        class="text-decoration-none"
                    >

                        <div class="border rounded-3 p-4 h-100">

                            <div class="d-flex align-items-start gap-3">

                                <div
                                    class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 48px; height: 48px;"
                                >
                                    <i class="fa-solid fa-prescription-bottle-medical fs-5"></i>
                                </div>

                                <div>

                                    <h6 class="fw-semibold text-dark mb-1">
                                        Prescriptions
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        View and create prescriptions
                                    </p>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>


                <!-- Appointment History -->
                <div class="col-md-4">

                    <a
                        href="#"
                        class="text-decoration-none"
                    >

                        <div class="border rounded-3 p-4 h-100">

                            <div class="d-flex align-items-start gap-3">

                                <div
                                    class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 48px; height: 48px;"
                                >
                                    <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                                </div>

                                <div>

                                    <h6 class="fw-semibold text-dark mb-1">
                                        Appointment History
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        View all patient visits
                                    </p>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

