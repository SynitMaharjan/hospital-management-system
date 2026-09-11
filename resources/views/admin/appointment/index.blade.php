@extends('layouts.dashboard')

@section('dashboard-content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Appointments</h3>
        <p class="text-muted mb-0">
            View and monitor all hospital appointments.
        </p>
    </div>

    <span class="badge bg-primary-subtle text-primary px-3 py-2">
        <i class="fa-solid fa-calendar-check me-1"></i>
        {{ $appointments->total() }} Appointments
    </span>

</div>

    {{-- Search & Filters --}}

    <form
        method="GET"
        action="{{ route('admin.appointment.index') }}"
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
                placeholder="Search appointments..."
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
            >
                <i class="fa-solid fa-filter me-1"></i>
                Filter
            </button>


            <div
                class="dropdown-menu p-3 shadow-sm border-0"
                style="min-width: 270px;"
            >

                <div class="fw-semibold mb-3">
                    Filter Appointments
                </div>


                {{-- Status --}}
                <label
                    for="status"
                    class="form-label small text-muted mb-1"
                >
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-select form-select-sm mb-3"
                >

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="pending"
                        {{ request('status') === 'pending' ? 'selected' : '' }}
                    >
                        Pending
                    </option>

                    <option
                        value="confirmed"
                        {{ request('status') === 'confirmed' ? 'selected' : '' }}
                    >
                        Confirmed
                    </option>

                    <option
                        value="completed"
                        {{ request('status') === 'completed' ? 'selected' : '' }}
                    >
                        Completed
                    </option>

                    <option
                        value="cancelled"
                        {{ request('status') === 'cancelled' ? 'selected' : '' }}
                    >
                        Cancelled
                    </option>

                </select>


                {{-- Doctor --}}
                <label
                    for="doctor"
                    class="form-label small text-muted mb-1"
                >
                    Doctor
                </label>

                <select
                    name="doctor"
                    id="doctor"
                    class="form-select form-select-sm mb-3"
                >

                    <option value="">
                        All Doctors
                    </option>

                    @foreach($doctors as $doctor)

                        <option
                            value="{{ $doctor->id }}"
                            {{ request('doctor') == $doctor->id ? 'selected' : '' }}
                        >
                            Dr. {{ $doctor->user->name }}
                        </option>

                    @endforeach

                </select>


                {{-- Department --}}
                <label
                    for="department"
                    class="form-label small text-muted mb-1"
                >
                    Department
                </label>

                <select
                    name="department"
                    id="department"
                    class="form-select form-select-sm mb-3"
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


                {{-- Date --}}
                <label
                    for="date"
                    class="form-label small text-muted mb-1"
                >
                    Appointment Date
                </label>

                <input
                    type="date"
                    name="date"
                    id="date"
                    class="form-control form-control-sm"
                    value="{{ request('date') }}"
                >

            </div>

        </div>


        {{-- Search --}}
        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-magnifying-glass me-1"></i>
            Search
        </button>


        {{-- Clear --}}
        @if(request()->hasAny([
            'search',
            'status',
            'doctor',
            'department',
            'date'
        ]))

            <a
                href="{{ route('admin.appointment.index') }}"
                class="btn btn-outline-secondary"
                title="Clear search and filters"
            >
                <i class="fa-solid fa-xmark me-1"></i>
                Clear
            </a>

        @endif

    </form>


{{-- Appointment Table Card --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white border-bottom py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5 class="fw-semibold mb-1">
                    All Appointments
                </h5>

                <small class="text-muted">
                    Appointment records across all doctors and patients
                </small>
            </div>

            <div class="text-muted small">
                <i class="fa-solid fa-calendar-days me-1"></i>
                {{ $appointments->total() }} records
            </div>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="ps-4">S.N</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($appointments as $appointment)

                        <tr>

                            {{-- Appointment ID --}}
                            <td class="ps-4 text-muted">
                                {{ $appointment->id }}
                            </td>


                            {{-- Patient --}}
                            <td>

                                <div class="d-flex align-items-center">

                                   <img
                                        src="{{ $appointment->patient?->user?->profile_picture
                                            ? asset('storage/' . $appointment->patient->user->profile_picture)
                                            : asset('images/default-profile.jpg') }}"
                                        alt="{{ $appointment->patient?->user?->name }}"
                                        class="rounded-circle me-2"
                                        style="width: 40px; height: 40px; object-fit: cover;"
                                    >

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $appointment->patient?->user?->name ?? 'N/A' }}
                                        </div>

                                        <small class="text-muted">
                                            Patient
                                        </small>
                                    </div>

                                </div>

                            </td>


                            {{-- Doctor --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <img
                                        src="{{ $appointment->doctor?->user?->profile_picture
                                            ? asset('storage/' . $appointment->doctor->user->profile_picture)
                                            : asset('images/default-profile.jpg') }}"
                                        alt="{{ $appointment->doctor?->user?->name }}"
                                        class="rounded-circle me-2"
                                        style="width: 40px; height: 40px; object-fit: cover;"
                                    >

                                    <div>
                                        <div class="fw-semibold">
                                            Dr. {{ $appointment->doctor?->user?->name ?? 'N/A' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $appointment->doctor?->specialization ?? 'Doctor' }}
                                        </small>
                                    </div>

                                </div>

                            </td>


                            {{-- Date --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $appointment->appointment_date?->format('M d, Y') }}
                                </div>

                                <small class="text-muted">
                                    {{ $appointment->appointment_date?->format('l') }}
                                </small>

                            </td>


                            {{-- Time --}}
                            <td>

                                <span class="text-muted">
                                    <i class="fa-regular fa-clock me-1"></i>

                                    {{ $appointment->appointment_time
                                        ? $appointment->appointment_time->format('h:i A')
                                        : 'N/A'
                                    }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @php
                                    $status = $appointment->status->value ?? $appointment->status;

                                    $statusClass = match ($status) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'completed' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span
                                    class="badge bg-{{ $statusClass }}-subtle
                                           text-{{ $statusClass }} px-3 py-2"
                                >

                                    @if($status === 'pending')
                                        <i class="fa-solid fa-clock me-1"></i>

                                    @elseif($status === 'confirmed')
                                        <i class="fa-solid fa-circle-check me-1"></i>

                                    @elseif($status === 'completed')
                                        <i class="fa-solid fa-check-double me-1"></i>

                                    @elseif($status === 'cancelled')
                                        <i class="fa-solid fa-circle-xmark me-1"></i>

                                    @else
                                        <i class="fa-solid fa-circle-question me-1"></i>
                                    @endif

                                    {{ ucfirst($status) }}

                                </span>

                            </td>


                            {{-- Reason --}}
                            <td style="max-width: 220px;">

                                @if($appointment->reason)

                                    <span
                                        class="text-muted"
                                        title="{{ $appointment->reason }}"
                                    >
                                        {{ \Illuminate\Support\Str::limit(
                                            $appointment->reason,
                                            35
                                        ) }}
                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fa-regular fa-calendar-xmark fs-1 mb-3"></i>

                                    <h5 class="fw-semibold">
                                        No appointments found
                                    </h5>

                                    <p class="mb-0">
                                        There are currently no appointments in the system.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- Pagination --}}
    @if($appointments->hasPages())

        <div class="card-footer bg-white border-top py-3">

            <div class="d-flex justify-content-between align-items-center">

                <small class="text-muted">

                    Showing
                    <strong>{{ $appointments->firstItem() }}</strong>
                    to
                    <strong>{{ $appointments->lastItem() }}</strong>
                    of
                    <strong>{{ $appointments->total() }}</strong>
                    appointments

                </small>

                <div>
                    {{ $appointments->links() }}
                </div>

            </div>

        </div>

    @endif

</div>

@endsection

