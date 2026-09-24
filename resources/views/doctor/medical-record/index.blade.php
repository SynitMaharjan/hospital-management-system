@extends('layouts.dashboard')

@section('page-title')
    Medical Records
@endsection

@section('dashboard-content')

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <div class="text-primary fs-4">
                    <i class="fa-solid fa-file-medical"></i>
                </div>

                <h2 class="fw-semibold mb-0">
                    Medical Records
                </h2>

            </div>

            <p class="text-muted mb-0">
                Clinical records for your patients
            </p>

        </div>


        <a
            href="{{ route('doctor.medical-record.create') }}"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-plus me-1"></i>
            New Record
        </a>

    </div>


    {{-- Search & Filters --}}
    <form
        method="GET"
        action="{{ route('doctor.medical-record.index') }}"
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
                placeholder="Search medical records..."
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
                style="min-width: 280px;"
            >

                <div class="fw-semibold mb-3">
                    Filter Medical Records
                </div>


                {{-- Date From --}}
                <div class="mb-3">

                    <label
                        for="date_from"
                        class="form-label small text-muted mb-1"
                    >
                        From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        id="date_from"
                        class="form-control form-control-sm"
                        value="{{ request('date_from') }}"
                    >

                </div>


                {{-- Date To --}}
                <div>

                    <label
                        for="date_to"
                        class="form-label small text-muted mb-1"
                    >
                        To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        id="date_to"
                        class="form-control form-control-sm"
                        value="{{ request('date_to') }}"
                    >

                </div>

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
        @if(request()->hasAny(['search', 'date_from', 'date_to']))

            <a
                href="{{ route('doctor.medical-record.index') }}"
                class="btn btn-outline-secondary"
                title="Clear search and filters"
            >

                <i class="fa-solid fa-xmark me-1"></i>
                Clear

            </a>

        @endif

    </form>


    <!-- Medical Records Card -->
    <div class="card border-0 shadow-sm">

        <!-- Card Header -->
        <div class="card-header bg-white border-0 px-4 py-3">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

                <div>

                    <h5 class="fw-semibold mb-1">
                        Medical Records
                    </h5>

                    <small class="text-muted">
                        Clinical information recorded during patient visits
                    </small>

                </div>


                @if($medicalRecords->total() > 0)

                    <span class="badge bg-primary-subtle text-primary px-3 py-2">

                        {{ $medicalRecords->total() }}

                        {{ $medicalRecords->total() === 1 ? 'Record' : 'Records' }}

                    </span>

                @endif

            </div>

        </div>


        <!-- Table -->
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4 py-3">
                            Patient
                        </th>

                        <th class="py-3">
                            Patient #
                        </th>

                        <th class="py-3">
                            Record Date
                        </th>

                        <th class="py-3">
                            Diagnosis
                        </th>

                        <th class="py-3">
                            Chief Complaint
                        </th>

                        <th class="pe-4 text-end py-3">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($medicalRecords as $record)

                        <tr>

                            <!-- Patient -->
                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    @if($record->patient->user)

                                        <img
                                            src="{{ $record->patient->user->profile_picture_url }}"
                                            alt="{{ $record->patient->full_name }}"
                                            class="rounded-circle border"
                                            width="44"
                                            height="44"
                                            style="object-fit: cover;"
                                        >

                                    @else

                                        <div
                                            class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 44px; height: 44px;"
                                        >
                                            <i class="fa-solid fa-user"></i>
                                        </div>

                                    @endif


                                    <div>

                                        <div class="fw-semibold">
                                            {{ $record->patient->full_name }}
                                        </div>

                                        <small class="text-muted">

                                            <i class="fa-solid fa-phone fa-xs me-1"></i>

                                            {{ $record->patient->phone ?? 'No phone' }}

                                        </small>

                                    </div>

                                </div>

                            </td>


                            <!-- Patient Number -->
                            <td>

                                <span class="fw-medium">
                                    {{ $record->patient->patient_number }}
                                </span>

                            </td>


                            <!-- Record Date -->
                            <td>

                                <div class="fw-medium">

                                    <i class="fa-regular fa-calendar me-1 text-muted"></i>

                                    {{ $record->record_date->format('M d, Y') }}

                                </div>

                            </td>


                            <!-- Diagnosis -->
                            <td>

                                @if($record->diagnosis)

                                    <div
                                        class="text-truncate"
                                        style="max-width: 220px;"
                                        title="{{ $record->diagnosis }}"
                                    >
                                        {{ $record->diagnosis }}
                                    </div>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <!-- Chief Complaint -->
                            <td>

                                @if($record->chief_complaint)

                                    <div
                                        class="text-truncate text-muted"
                                        style="max-width: 220px;"
                                        title="{{ $record->chief_complaint }}"
                                    >
                                        {{ $record->chief_complaint }}
                                    </div>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <!-- Action -->
                            <td class="pe-4 text-end">

                                <a
                                    href="{{ route('doctor.medical-record.show', $record) }}"
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
                                        class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 64px; height: 64px;"
                                    >
                                        <i class="fa-solid fa-file-medical fs-4"></i>
                                    </div>


                                    <h6 class="fw-semibold mb-1">
                                        No medical records found
                                    </h6>


                                    <p class="text-muted small mb-3">
                                        No records match your current search or filters.
                                    </p>


                                    @if(request()->hasAny(['search', 'date_from', 'date_to']))

                                        <a
                                            href="{{ route('doctor.medical-record.index') }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >

                                            <i class="fa-solid fa-rotate-left me-1"></i>
                                            Clear Filters

                                        </a>

                                    @else

                                        <a
                                            href="{{ route('doctor.medical-record.create') }}"
                                            class="btn btn-sm btn-primary"
                                        >

                                            <i class="fa-solid fa-plus me-1"></i>
                                            Create Medical Record

                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        @if($medicalRecords->hasPages())

            <div class="p-3 border-top">

                {{ $medicalRecords->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
