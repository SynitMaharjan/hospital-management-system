@extends('layouts.dashboard')

@section('page-title')
    Check-In Patients
@endsection

@section('dashboard-content')

<div class="container-fluid px-0">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-semibold mb-1">
                Check-In Patients
            </h2>

            <p class="text-muted mb-0">
                Manage today's patient check-ins and consultation status.
            </p>
        </div>

    </div>


    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- Today's Appointments --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 py-3">

            <h5 class="fw-semibold mb-1">
                Today's Appointments
            </h5>

            <p class="text-muted small mb-0">
                Confirmed appointments that have not been checked in yet.
            </p>

        </div>


        <div class="card-body p-0">

            @forelse($appointments as $appointment)

                <div class="d-flex align-items-center justify-content-between
                            px-4 py-3 border-top">

                    {{-- Patient Information --}}
                    <div>

                        <div class="fw-semibold">
                            {{ $appointment->patient->full_name }}
                        </div>

                        <div class="small text-muted mt-1">

                            Dr. {{ $appointment->doctor->user->name }}

                            <span class="mx-1">•</span>

                            {{ $appointment->doctor->department->name }}

                        </div>

                    </div>


                    {{-- Appointment Time --}}
                    <div class="text-center">

                        <div class="fw-semibold">
                            {{ $appointment->appointment_time->format('h:i A') }}
                        </div>

                    </div>


                    {{-- Check-In --}}
                    <div>

                        <form
                            method="POST"
                            action="{{ route('receptionist.check-in.store') }}"
                            class="d-inline"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="appointment_id"
                                value="{{ $appointment->id }}"
                            >

                            <button
                                type="submit"
                                class="btn btn-sm btn-success"
                            >
                                Check In
                                <i class="fa-solid fa-check ms-1"></i>
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="text-center text-muted py-5">

                    <i class="fa-solid fa-calendar-check fa-2x mb-3"></i>

                    <p class="mb-0">
                        No confirmed appointments are currently available for check-in.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- Checked-In Patients --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <h5 class="fw-semibold mb-1">
                Checked-In Patients
            </h5>

            <p class="text-muted small mb-0">
                Manage patients who have already checked in today.
            </p>

        </div>


        <div class="card-body p-0">

            @forelse($checkIns as $checkIn)

                <div class="d-flex align-items-center justify-content-between
                            px-4 py-3 border-top">

                    {{-- Patient Information --}}
                    <div>

                        <div class="fw-semibold">
                            {{ $checkIn->patient->full_name }}
                        </div>

                        <div class="small text-muted mt-1">

                            Dr. {{ $checkIn->appointment->doctor->user->name }}

                            <span class="mx-1">•</span>

                            {{ $checkIn->appointment->doctor->department->name }}

                        </div>

                        <div class="small text-muted mt-1">

                            Checked in at
                            {{ $checkIn->checked_in_at->format('h:i A') }}

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="text-center">

                        @if ($checkIn->status->value === 'waiting')

                            <span class="badge bg-warning text-dark">
                                Waiting
                            </span>

                        @elseif ($checkIn->status->value === 'in_consultation')

                            <span class="badge bg-info text-dark">
                                In Consultation
                            </span>

                        @elseif ($checkIn->status->value === 'completed')

                            <span class="badge bg-success">
                                Completed
                            </span>

                        @elseif ($checkIn->status->value === 'cancelled')

                            <span class="badge bg-danger">
                                Cancelled
                            </span>

                        @endif

                    </div>


                    {{-- Status Actions --}}
                    <div>

                        @if ($checkIn->status->value === 'waiting')

                            <form
                                method="POST"
                                action="{{ route('receptionist.check-in.status', $checkIn) }}"
                                class="d-inline"
                            >

                                @csrf
                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="in_consultation"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary"
                                >
                                    Start Consultation
                                    <i class="fa-solid fa-stethoscope ms-1"></i>
                                </button>

                            </form>


                        @elseif ($checkIn->status->value === 'in_consultation')

                            <form
                                method="POST"
                                action="{{ route('receptionist.check-in.status', $checkIn) }}"
                                class="d-inline"
                            >

                                @csrf
                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="completed"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-success"
                                >
                                    Complete
                                    <i class="fa-solid fa-check-double ms-1"></i>
                                </button>

                            </form>


                        @elseif ($checkIn->status->value === 'completed')

                            <span class="text-muted small">
                                Completed
                            </span>


                        @elseif ($checkIn->status->value === 'cancelled')

                            <span class="text-muted small">
                                Cancelled
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <div class="text-center text-muted py-5">

                    <i class="fa-solid fa-user-clock fa-2x mb-3"></i>

                    <p class="mb-0">
                        No patients have checked in today.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection