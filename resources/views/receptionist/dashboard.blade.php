@extends("layouts.dashboard")

@section("page-title")
    Receptionist Dashboard
@endsection

@section("dashboard-content")

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-semibold mb-1">
            Receptionist Dashboard
        </h4>
        <p class="text-muted mb-0">
            Overview of today's appointments and activities.
        </p>
    </div>


    {{-- Appointment Statistics --}}
    <div class="row g-4 mb-4">

        {{-- Today's Appointments --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small mb-1">
                                Today's Appointments
                            </div>

                            <h3 class="fw-semibold mb-0">
                                {{ $appointmentStats['today'] }}
                            </h3>
                        </div>

                        <div class="text-primary fs-3">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- Pending --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small mb-1">
                                Pending
                            </div>

                            <h3 class="fw-semibold mb-0">
                                {{ $appointmentStats['pending'] }}
                            </h3>
                        </div>

                        <div class="text-warning fs-3">
                            <i class="fa-solid fa-clock"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- Confirmed --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small mb-1">
                                Confirmed Today
                            </div>

                            <h3 class="fw-semibold mb-0">
                                {{ $appointmentStats['confirmed'] }}
                            </h3>
                        </div>

                        <div class="text-success fs-3">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- Completed --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small mb-1">
                                Completed Today
                            </div>

                            <h3 class="fw-semibold mb-0">
                                {{ $appointmentStats['completed'] }}
                            </h3>
                        </div>

                        <div class="text-success fs-3">
                            <i class="fa-solid fa-check-double"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- Today's Appointments --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="fw-semibold mb-1">
                        Today's Appointments
                    </h5>

                    <p class="text-muted small mb-0">
                        Appointments scheduled for today.
                    </p>
                </div>

                <a href="{{ route('receptionist.appointment.index') }}"
                   class="btn btn-sm btn-outline-primary">

                    View all
                    <i class="fa-solid fa-arrow-right ms-1"></i>

                </a>

            </div>
        </div>


        <div class="card-body p-0">

            @forelse($todayAppointments as $appointment)

                <div class="d-flex align-items-center justify-content-between
                            px-4 py-3 border-top">

                    {{-- Appointment Information --}}
                    <div>

                        <div class="fw-semibold">
                            {{ $appointment->patient->user->name }}
                        </div>

                        <div class="small text-muted mt-1">

                            Dr. {{ $appointment->doctor->user->name }}

                            <span class="mx-1">•</span>

                            {{ $appointment->doctor->department->name }}

                        </div>

                    </div>


                    {{-- Time --}}
                    <div class="text-center">

                        <div class="fw-semibold">
                            {{ $appointment->appointment_time->format('h:i A') }}
                        </div>

                    </div>


                    {{-- Status --}}
                    <div>

                        @if($appointment->status->value === 'pending')

                            <span class="badge text-bg-warning">
                                Pending
                            </span>

                        @elseif($appointment->status->value === 'confirmed')

                            <span class="badge text-bg-primary">
                                Confirmed
                            </span>

                        @elseif($appointment->status->value === 'completed')

                            <span class="badge text-bg-success">
                                Completed
                            </span>

                        @elseif($appointment->status->value === 'cancelled')

                            <span class="badge text-bg-danger">
                                Cancelled
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <div class="text-center text-muted py-5">

                    <i class="fa-solid fa-calendar-xmark fa-2x mb-3"></i>

                    <p class="mb-0">
                        No appointments scheduled for today.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection