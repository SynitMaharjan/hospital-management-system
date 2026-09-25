@extends('layouts.dashboard')

@section('page-title', 'My Appointments')

@section('dashboard-content')

<div class="container-fluid px-0">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold mb-1">
                My Appointments
            </h2>

            <p class="text-muted mb-0">
                View and manage your scheduled patient appointments
            </p>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}

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
        action="{{ route('doctor.appointment.index') }}"
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
                placeholder="Search patient or appointment..."
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
                    class="form-select form-select-sm"
                >
                    <option value="">
                        All Statuses
                    </option>

                    @foreach($statuses as $status)
                        <option
                            value="{{ $status->value }}"
                            @selected(request('status') === $status->value)
                        >
                            {{ ucfirst($status->value) }}
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
        @if(request()->hasAny(['search', 'status']))
            <a
                href="{{ route('doctor.appointment.index') }}"
                class="btn btn-outline-secondary"
                title="Clear search and filters"
            >
                <i class="fa-solid fa-xmark me-1"></i>
                Clear
            </a>
        @endif

    </form>

    {{-- Appointments Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>

                            <th class="px-4 py-3 text-nowrap">
                                Appointment #
                            </th>

                            <th class="py-3 text-nowrap">
                                Patient
                            </th>

                            <th class="py-3 text-nowrap">
                                Date
                            </th>

                            <th class="py-3 text-nowrap">
                                Time
                            </th>

                            <th class="py-3 text-nowrap">
                                Reason
                            </th>

                            <th class="py-3 text-nowrap">
                                Status
                            </th>

                            <th class="py-3 text-nowrap">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse($appointments as $appointment)

                            <tr>

                                {{-- Appointment Number --}}
                                <td class="px-4 text-nowrap">
                                    <span class="font-monospace fw-medium">
                                        {{ $appointment->appointment_number }}
                                    </span>
                                </td>

                                {{-- Patient --}}
                                <td>
                                    <div class="fw-medium">
                                        {{ $appointment->patient->full_name }}
                                    </div>

                                    @if($appointment->patient->email)
                                        <small class="text-muted">
                                            {{ $appointment->patient->email }}
                                        </small>
                                    @endif
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
                                <td>
                                    <span
                                        class="d-inline-block text-truncate"
                                        style="max-width: 200px;"
                                        title="{{ $appointment->reason }}"
                                    >
                                        {{ $appointment->reason }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="text-nowrap">

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

                                {{-- Actions --}}
                                <td class="text-nowrap">

                                    <a
                                        href="{{ route('doctor.appointment.show', $appointment->id) }}"
                                        class="btn btn-sm btn-primary"
                                        title="View Appointment"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center py-5 text-muted"
                                >
                                    <div class="mb-2">
                                        <i class="fa-solid fa-calendar-xmark fa-2x"></i>
                                    </div>

                                    @if(request()->hasAny(['search', 'status']))
                                        <div>
                                            No appointments match your search or filter.
                                        </div>

                                        <a
                                            href="{{ route('doctor.appointment.index') }}"
                                            class="btn btn-sm btn-outline-primary mt-3"
                                        >
                                            <i class="fa-solid fa-xmark me-1"></i>
                                            Clear Filters
                                        </a>
                                    @else
                                        <div>
                                            No appointments found.
                                        </div>
                                    @endif

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            @if($appointments->hasPages())
                <div class="p-3 border-top">
                    {{ $appointments->links() }}
                </div>
            @endif

        </div>

    </div>

</div>

@endsection

