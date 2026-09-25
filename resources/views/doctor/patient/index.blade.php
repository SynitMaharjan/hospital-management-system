@extends('layouts.dashboard')

@section('page-title')
    My Patients
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-1">

            <div class="text-primary fs-4">
                <i class="fa-solid fa-user-group"></i>
            </div>

            <h2 class="fw-semibold mb-0">
                My Patients
            </h2>

        </div>

        <p class="text-muted mb-0">
            Patients who have appointments with you
        </p>

    </div>


    {{-- Search --}}
    <form
        method="GET"
        action="{{ route('doctor.patient.index') }}"
        class="d-flex flex-wrap align-items-center gap-2 mb-4"
    >

        {{-- Search Input --}}
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
                id="search"
                class="form-control border-start-0 ps-0"
                placeholder="Search patient name, number, or phone..."
                value="{{ request('search') }}"
                autocomplete="off"
            >

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
        @if(request()->filled('search'))

            <a
                href="{{ route('doctor.patient.index') }}"
                class="btn btn-outline-secondary"
                title="Clear search"
            >
                <i class="fa-solid fa-xmark me-1"></i>
                Clear
            </a>

        @endif

    </form>


    {{-- Patient List Card --}}
    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}
        <div class="card-header bg-white border-0 px-4 py-3">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

                <div>

                    <h5 class="fw-semibold mb-1">
                        Patient List
                    </h5>

                    <small class="text-muted">
                        Patients assigned through your appointments
                    </small>

                </div>


                @if($patients->total() > 0)

                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                        {{ $patients->total() }}
                        {{ Str::plural('Patient', $patients->total()) }}
                    </span>

                @endif

            </div>

        </div>


        {{-- Table --}}
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4 py-3">
                            Patient
                        </th>

                        <th class="py-3">
                            Patient Number
                        </th>

                        <th class="py-3">
                            Phone
                        </th>

                        <th class="py-3">
                            Last Appointment
                        </th>

                        <th class="text-center py-3">
                            Status
                        </th>

                        <th class="pe-4 text-end py-3">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($patients as $patient)

                        @php

                            $latestAppointment = $patient->latestAppointment;

                            $lastAppointmentDate = $latestAppointment
                                ? $latestAppointment->appointment_date->format('M d, Y')
                                : 'No appointments';

                            $lastAppointmentStatus = $latestAppointment
                                ? $latestAppointment->status->value
                                : null;

                            $statusClass = match ($lastAppointmentStatus) {
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                'confirmed' => 'primary',
                                'pending' => 'warning',
                                default => 'secondary',
                            };

                            $statusIcon = match ($lastAppointmentStatus) {
                                'completed' => 'fa-circle-check',
                                'cancelled' => 'fa-circle-xmark',
                                'confirmed' => 'fa-circle-check',
                                'pending' => 'fa-clock',
                                default => 'fa-circle-question',
                            };

                        @endphp


                        <tr>

                            {{-- Patient --}}
                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    @if($patient->user)

                                        <img
                                            src="{{ $patient->user->profile_picture_url }}"
                                            alt="{{ $patient->full_name }}"
                                            class="rounded-circle border"
                                            width="46"
                                            height="46"
                                            style="object-fit: cover;"
                                        >

                                    @else

                                        <div
                                            class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 46px; height: 46px;"
                                        >
                                            <i class="fa-solid fa-user"></i>
                                        </div>

                                    @endif


                                    <div>

                                        <div class="fw-semibold">
                                            {{ $patient->full_name }}
                                        </div>

                                        <small class="text-muted">

                                            @if($patient->date_of_birth)

                                                {{ $patient->date_of_birth->age }} years old

                                            @else

                                                Age not available

                                            @endif

                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Patient Number --}}
                            <td>

                                <span class="fw-medium">
                                    {{ $patient->patient_number }}
                                </span>

                            </td>


                            {{-- Phone --}}
                            <td>

                                <div class="d-flex align-items-center gap-2 text-muted">

                                    <i class="fa-solid fa-phone fa-sm"></i>

                                    <span>
                                        {{ $patient->phone ?: 'Not available' }}
                                    </span>

                                </div>

                            </td>


                            {{-- Last Appointment --}}
                            <td>

                                @if($latestAppointment)

                                    <div class="fw-medium">
                                        {{ $lastAppointmentDate }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $latestAppointment->appointment_time->format('h:i A') }}
                                    </small>

                                @else

                                    <span class="text-muted">
                                        No appointments
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="text-center">

                                @if($lastAppointmentStatus)

                                    <span
                                        class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} px-3 py-2"
                                    >

                                        <i class="fa-solid {{ $statusIcon }} me-1"></i>

                                        {{ ucfirst($lastAppointmentStatus) }}

                                    </span>

                                @else

                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                        N/A
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
                            <td class="pe-4 text-end">

                                <a
                                    href="{{ route('doctor.patient.show', $patient) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    <i class="fa-solid fa-eye me-1"></i>
                                    View
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <div class="py-3">

                                    <div
                                        class="mx-auto mb-3 rounded-circle bg-light d-flex align-items-center justify-content-center text-muted"
                                        style="width: 64px; height: 64px;"
                                    >
                                        <i class="fa-solid fa-user-group fs-4"></i>
                                    </div>

                                    <h6 class="fw-semibold mb-1">
                                        No patients found
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        @if(request()->filled('search'))
                                            No patients match your search.
                                        @else
                                            You don't have any patients yet.
                                        @endif
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($patients->hasPages())

            <div class="card-footer bg-white border-0 px-4 py-3">

                {{ $patients->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
