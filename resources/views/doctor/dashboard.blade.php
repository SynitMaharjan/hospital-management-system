@extends('layouts.dashboard')

@section('page-title')
  Doctor Dashboard
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

                <div>
                    <h1 class="fw-bold mb-1">
                        <i class="fa-solid fa-user-doctor text-primary me-2"></i>
                        Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }},
                        Dr. {{ Auth::user()->name }}
                    </h1>

                    <p class="text-muted mb-0">
                        {{ now()->format('l, F j, Y') }}
                        •
                        {{ now()->format('g:i A') }}
                    </p>
                </div>

                <div class="d-flex gap-2 flex-wrap">

                    <a
                        href="{{ route('doctor.appointment.index') }}"
                        class="btn btn-primary d-flex align-items-center gap-2"
                    >
                        <i class="fa-solid fa-plus"></i>
                        New Appointment
                    </a>

                    <a
                        href="{{ route('doctor.appointment.index') }}"
                        class="btn btn-outline-secondary d-flex align-items-center gap-2"
                    >
                        <i class="fa-solid fa-calendar-check"></i>
                        View All
                    </a>

                </div>

            </div>

        </div>
    </div>


    <!-- Stats Cards -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Pending Arrivals
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $pendingCount }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Completed Today
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $completedTodayCount }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Upcoming Appointments
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $upcomingAppointmentCount }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        Total Patients
                    </p>

                    <h3 class="fw-semibold mb-0">
                        {{ $totalPatients }}
                    </h3>

                </div>
            </div>
        </div>

    </div>


    <!-- Main Content Grid -->
    <div class="row g-4">

        <!-- Today's Schedule -->
        <div class="col-12 col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>

                        <div>
                            <h5 class="fw-semibold mb-0">
                                Today's Schedule
                            </h5>

                            <small class="text-muted">
                                {{ $todayAppointments->count() }}
                                appointment{{ $todayAppointments->count() !== 1 ? 's' : '' }}
                            </small>
                        </div>

                    </div>

                    <a
                        href="{{ route('doctor.appointment.index') }}"
                        class="btn btn-sm btn-outline-primary"
                    >
                        <i class="fa-solid fa-chevron-right me-1"></i>
                        View All
                    </a>

                </div>


                <div class="card-body p-0">

                    @if($todayAppointments->isEmpty())

                        <div class="text-center py-4">

                            <div
                                class="empty-state mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;"
                            >
                                <i class="fa-regular fa-calendar-xmark fs-1 text-muted"></i>
                            </div>

                            <h6 class="fw-medium text-muted mb-1">
                                No appointments today
                            </h6>

                            <p class="text-muted small mb-3">
                                Enjoy your free day!
                            </p>

                        </div>

                    @else

                        <div class="schedule-list">

                            @foreach($todayAppointments as $index => $appointment)

                                @php
                                    $status = $appointment->status->value;
                                @endphp

                                <div class="p-3 border-top {{ $index === 0 ? 'border-0' : '' }}">

                                    <div class="d-flex align-items-center gap-3">

                                        <!-- Time Column -->
                                        <div class="time-column text-center min-w-80px">

                                            <div class="fw-semibold fs-5
                                                {{
                                                    $status === 'completed'
                                                        ? 'text-success'
                                                        : (
                                                            $appointment->appointment_time < now()->format('H:i')
                                                            && $status !== 'completed'
                                                                ? 'text-danger'
                                                                : 'text-primary'
                                                        )
                                                }}"
                                            >
                                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                            </div>

                                            <span
                                                class="badge
                                                {{
                                                    $status === 'completed'
                                                        ? 'bg-success'
                                                        : (
                                                            $status === 'cancelled'
                                                                ? 'bg-danger'
                                                                : (
                                                                    $appointment->appointment_time < now()->format('H:i')
                                                                    && $status !== 'completed'
                                                                        ? 'bg-danger'
                                                                        : 'bg-warning'
                                                                )
                                                        )
                                                }}
                                                rounded-pill px-2 py-1 small"
                                            >
                                                {{ ucfirst($status) }}
                                            </span>

                                        </div>


                                        <!-- Patient Info -->
                                        <div class="flex-grow-1 min-w-0">

                                            <div class="d-flex align-items-center gap-2 mb-1">

                                                @if($appointment->patient->user)

                                                    <img
                                                        src="{{ $appointment->patient->user->profile_picture_url }}"
                                                        alt="{{ $appointment->patient->full_name }}"
                                                        class="rounded-circle flex-shrink-0"
                                                        style="width: 36px; height: 36px; object-fit: cover;"
                                                    >

                                                @else

                                                    <div
                                                        class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center text-primary flex-shrink-0"
                                                        style="width: 36px; height: 36px;"
                                                    >
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>

                                                @endif

                                                <div>

                                                    <h6 class="fw-medium mb-0">
                                                        {{ $appointment->patient->full_name }}
                                                    </h6>

                                                    <small class="text-muted">
                                                        {{ $appointment->patient->phone ?? 'No phone' }}
                                                    </small>

                                                </div>

                                            </div>


                                            <div class="d-flex flex-wrap gap-2 small text-muted">

                                                @if($appointment->reason)

                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fa-regular fa-comment"></i>
                                                        {{ Str::limit($appointment->reason, 50) }}
                                                    </span>

                                                @endif

                                                @if($appointment->department)

                                                    <span class="d-flex align-items-center gap-1">
                                                        <i class="fa-solid fa-building"></i>
                                                        {{ $appointment->department->name }}
                                                    </span>

                                                @endif

                                            </div>

                                        </div>


                                        <!-- Actions -->
                                        <div class="d-flex gap-1">

                                            @if($status !== 'completed' && $status !== 'cancelled')

                                                <a
                                                    href="{{ route('doctor.appointment.show', $appointment) }}"
                                                    class="btn btn-sm btn-primary"
                                                    title="View Details"
                                                >
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-success complete-appointment-btn"
                                                    data-appointment-id="{{ $appointment->id }}"
                                                    title="Mark Complete"
                                                >
                                                    <i class="fa-solid fa-check"></i>
                                                </button>

                                            @else

                                                <a
                                                    href="{{ route('doctor.appointment.show', $appointment) }}"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    title="View Details"
                                                >
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </div>


        <!-- Sidebar -->
        <div class="col-12 col-lg-4">

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white border-0 pb-0">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-bolt"></i>
                        </div>

                        <h5 class="fw-semibold mb-0">
                            Quick Actions
                        </h5>

                    </div>

                </div>


                <div class="card-body p-2">

                    <div class="d-grid gap-2">

                        <!-- New Appointment -->
                        <a
                            href="{{ route('doctor.appointment.index') }}"
                            class="btn btn-light border d-flex align-items-center gap-3 p-3 text-start hover-shadow transition-all"
                        >

                            <div
                                class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 52px; height: 52px;"
                            >
                                <i class="fa-solid fa-calendar-plus fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-medium mb-0">
                                    New Appointment
                                </h6>

                                <small class="text-muted">
                                    Schedule a new patient visit
                                </small>
                            </div>

                        </a>


                        <!-- Medical Records -->
                        <a
                            href="{{ route('doctor.medical-record.index') }}"
                            class="btn btn-light border d-flex align-items-center gap-3 p-3 text-start hover-shadow transition-all"
                        >

                            <div
                                class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 52px; height: 52px;"
                            >
                                <i class="fa-solid fa-file-medical fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-medium mb-0">
                                    Medical Records
                                </h6>

                                <small class="text-muted">
                                    Access patient histories
                                </small>
                            </div>

                        </a>


                        <!-- Prescriptions -->
                        <a
                            href="{{ route('doctor.prescription.index') }}"
                            class="btn btn-light border d-flex align-items-center gap-3 p-3 text-start hover-shadow transition-all"
                        >

                            <div
                                class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 52px; height: 52px;"
                            >
                                <i class="fa-solid fa-prescription-bottle-medical fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-medium mb-0">
                                    Prescriptions
                                </h6>

                                <small class="text-muted">
                                    Manage patient prescriptions
                                </small>
                            </div>

                        </a>


                        <!-- Lab Results -->
                        <a
                            href="#"
                            class="btn btn-light border d-flex align-items-center gap-3 p-3 text-start hover-shadow transition-all"
                        >

                            <div
                                class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 52px; height: 52px;"
                            >
                                <i class="fa-solid fa-flask fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-medium mb-0">
                                    Lab Results
                                </h6>

                                <small class="text-muted">
                                    Review test results
                                </small>
                            </div>

                        </a>

                    </div>

                </div>

            </div>


            <!-- Upcoming Appointments Summary -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-calendar-days fs-4"></i>
                        </div>

                        <div>

                            <h5 class="fw-semibold mb-0">
                                Next 7 Days
                            </h5>

                            <small class="text-muted">
                                {{ $upcomingAppointments->count() }} upcoming
                            </small>

                        </div>

                    </div>

                </div>


                <div class="card-body p-0">

                    @if($upcomingAppointments->isEmpty())

                        <div class="text-center py-4">

                            <div
                                class="empty-state mx-auto mb-2 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;"
                            >
                                <i class="fa-regular fa-calendar-check fs-1 text-muted"></i>
                            </div>

                            <small class="text-muted">
                                No upcoming appointments
                            </small>

                        </div>

                    @else

                        <div class="upcoming-list">

                            @foreach($upcomingAppointments as $index => $appointment)

                                <div class="p-3 border-top {{ $index === 0 ? 'border-0' : '' }}">

                                    <div class="d-flex align-items-center gap-3">

                                        <div
                                            class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center flex-column flex-shrink-0"
                                            style="width: 58px; height: 58px;"
                                        >
                                            <small class="fw-bold">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d') }}
                                            </small>

                                            <div class="fw-bold small">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                            </div>

                                        </div>


                                        <div class="flex-grow-1 min-w-0">

                                            <h6 class="fw-medium mb-1 text-truncate">
                                                {{ $appointment->patient->full_name }}
                                            </h6>

                                            <small class="text-muted">
                                                {{ Str::limit($appointment->reason ?? 'No reason provided', 40) }}
                                            </small>

                                        </div>


                                        <a
                                            href="{{ route('doctor.appointment.show', $appointment) }}"
                                            class="btn btn-sm btn-outline-primary px-2"
                                        >
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <!-- Recent Patients Section -->
    <div class="row g-4 mt-4">

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>

                            <h5 class="fw-semibold mb-0">
                                Recent Patients
                            </h5>

                            <small class="text-muted">
                                {{ $recentPatients->count() }} patients seen recently
                            </small>

                        </div>

                    </div>

                    <a
                        href="{{ route('doctor.patient.index') }}"
                        class="btn btn-sm btn-outline-secondary"
                    >
                        View All Patients
                    </a>

                </div>


                <div class="card-body p-0">

                    @if($recentPatients->isEmpty())

                        <div class="text-center py-4">

                            <div
                                class="empty-state mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;"
                            >
                                <i class="fa-solid fa-users fs-1 text-muted"></i>
                            </div>

                            <h6 class="fw-medium text-muted mb-1">
                                No recent patients
                            </h6>

                            <p class="text-muted small mb-3">
                                Patients you've seen will appear here
                            </p>

                        </div>

                    @else

                        <div class="table-responsive">

                            <table class="table table-hover mb-0 align-middle">

                                <thead class="table-light">

                                    <tr>
                                        <th class="ps-4">Patient</th>
                                        <th>Contact</th>
                                        <th>Last Visit</th>
                                        <th>Visits</th>
                                        <th>Status</th>
                                        <th class="pe-4">Actions</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($recentPatients as $patient)

                                        @php

                                            $lastVisit = $patient->appointments
                                                ->where('doctor_id', $doctor->id)
                                                ->whereNotNull('appointment_date')
                                                ->sortByDesc('appointment_date')
                                                ->first();

                                            $visitCount = $patient->appointments
                                                ->where('doctor_id', $doctor->id)
                                                ->count();

                                        @endphp

                                        <tr>

                                            <td class="ps-4">

                                                <div class="d-flex align-items-center gap-3">

                                                    @if($patient->user)

                                                        <img
                                                            src="{{ $patient->user->profile_picture_url }}"
                                                            alt="{{ $patient->full_name }}"
                                                            class="rounded-circle flex-shrink-0"
                                                            style="width: 44px; height: 44px; object-fit: cover;"
                                                        >

                                                    @else

                                                        <div
                                                            class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center text-info flex-shrink-0"
                                                            style="width: 44px; height: 44px;"
                                                        >
                                                            <i class="fa-solid fa-user fs-5"></i>
                                                        </div>

                                                    @endif


                                                    <div>

                                                        <h6 class="fw-medium mb-0">
                                                            {{ $patient->full_name }}
                                                        </h6>

                                                        <small class="text-muted">
                                                            {{ $patient->date_of_birth
                                                                ? \Carbon\Carbon::parse($patient->date_of_birth)->age . ' years'
                                                                : 'Age unknown'
                                                            }}
                                                        </small>

                                                    </div>

                                                </div>

                                            </td>


                                            <td>

                                                <div class="d-flex flex-column gap-1 small">

                                                    @if($patient->phone)

                                                        <span class="d-flex align-items-center gap-1 text-muted">
                                                            <i class="fa-solid fa-phone"></i>
                                                            {{ $patient->phone }}
                                                        </span>

                                                    @endif

                                                    @if($patient->email)

                                                        <span class="d-flex align-items-center gap-1 text-muted">
                                                            <i class="fa-solid fa-envelope"></i>
                                                            {{ $patient->email }}
                                                        </span>

                                                    @endif

                                                </div>

                                            </td>


                                            <td>

                                                @if($lastVisit)

                                                    <div>

                                                        <div class="fw-medium">
                                                            {{ $lastVisit->appointment_date->format('M d, Y') }}
                                                        </div>

                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($lastVisit->appointment_time)->format('g:i A') }}
                                                        </small>

                                                    </div>

                                                @else

                                                    <span class="text-muted">
                                                        Never
                                                    </span>

                                                @endif

                                            </td>


                                            <td>

                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">
                                                    {{ $visitCount }}
                                                    visit{{ $visitCount !== 1 ? 's' : '' }}
                                                </span>

                                            </td>


                                            <td>

                                                <span
                                                    class="badge
                                                    {{
                                                        $lastVisit
                                                        && $lastVisit->appointment_date->gte(now()->subDays(30))
                                                            ? 'bg-success'
                                                            : 'bg-secondary'
                                                    }}
                                                    rounded-pill px-2 py-1"
                                                >
                                                    {{
                                                        $lastVisit
                                                        && $lastVisit->appointment_date->gte(now()->subDays(30))
                                                            ? 'Active'
                                                            : 'Inactive'
                                                    }}
                                                </span>

                                            </td>


                                            <td class="pe-4">

                                                <div
                                                    class="btn-group btn-group-sm"
                                                    role="group"
                                                >

                                                    <a
                                                        href="{{ route('doctor.patient.show', $patient) }}"
                                                        class="btn btn-outline-secondary"
                                                        title="View Patient"
                                                    >
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>

                                                    <a
                                                        href="{{ route('doctor.medical-record.index', ['patient_id' => $patient->id]) }}"
                                                        class="btn btn-outline-primary"
                                                        title="Medical Records"
                                                    >
                                                        <i class="fa-solid fa-file-medical"></i>
                                                    </a>

                                                    <a
                                                        href="{{ route('doctor.prescription.index', ['patient_id' => $patient->id]) }}"
                                                        class="btn btn-outline-info"
                                                        title="Prescriptions"
                                                    >
                                                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                                                    </a>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection