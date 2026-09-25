@extends('layouts.dashboard')

@section('page-title', 'My Appointments')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Appointments</h4>
        <p class="text-muted mb-0">
            View your upcoming and previous appointments.
        </p>
    </div>
</div>

@if($appointments->isEmpty())

{{-- Empty State --}}
<div class="card border-0 shadow-sm">

    <div class="card-body text-center py-5">

        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>

        <h5 class="fw-semibold mb-2">
            No appointments found
        </h5>

        <p class="text-muted mb-0">
            You don't have any appointments scheduled at the moment.
        </p>

    </div>

</div>

@else

{{-- Appointments Table --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="ps-4">Appointment #</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach($appointments as $appointment)

                        <tr>

                            {{-- Appointment Number --}}
                            <td class="ps-4 fw-semibold">
                                {{ $appointment->appointment_number }}
                            </td>


                            {{-- Doctor --}}
                            <td>

                                <div class="fw-semibold">
                                    Dr. {{ $appointment->doctor->user->name }}
                                </div>

                                <small class="text-muted">
                                    {{ $appointment->doctor->specialization }}
                                </small>

                            </td>


                            {{-- Department --}}
                            <td>
                                {{ $appointment->doctor->department->name }}
                            </td>


                            {{-- Date --}}
                            <td class="text-nowrap">
                                {{ $appointment->appointment_date->format('M d, Y') }}
                            </td>


                            {{-- Time --}}
                            <td class="text-nowrap">
                                {{ $appointment->appointment_time->format('h:i A') }}
                            </td>


                            {{-- Reason --}}
                            <td style="min-width: 180px; max-width: 250px;">

                                <span
                                    class="d-block text-truncate"
                                    title="{{ $appointment->reason }}"
                                >
                                    {{ $appointment->reason }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @php
                                    $statusClass = match($appointment->status->value) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        'completed' => 'info',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($appointment->status->value) }}
                                </span>

                            </td>


                            {{-- Action --}}
                            <td class="text-end pe-4">

                                <a
                                    href="{{ route('patient.appointment.show', $appointment->id) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    <i class="fas fa-eye me-1"></i>
                                    View
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="card-footer bg-white border-top">
            {{ $appointments->links() }}
        </div>

    </div>

</div>

@endif

@endsection
