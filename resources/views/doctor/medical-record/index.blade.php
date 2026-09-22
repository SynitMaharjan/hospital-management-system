@extends('layouts.dashboard')

@section('page-title')
    Medical Records
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

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


    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <form
                method="GET"
                action="{{ route('doctor.medical-record.index') }}"
            >

                <div class="row g-3 align-items-end">

                    <!-- Search -->
                    <div class="col-lg-5 col-md-6">

                        <label
                            for="search"
                            class="form-label fw-medium"
                        >
                            Search Records
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                id="search"
                                class="form-control"
                                placeholder="Patient name, number, phone, diagnosis..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    <!-- Date From -->
                    <div class="col-lg-2 col-md-3">

                        <label
                            for="date_from"
                            class="form-label fw-medium"
                        >
                            From
                        </label>

                        <input
                            type="date"
                            name="date_from"
                            id="date_from"
                            class="form-control"
                            value="{{ request('date_from') }}"
                        >

                    </div>


                    <!-- Date To -->
                    <div class="col-lg-2 col-md-3">

                        <label
                            for="date_to"
                            class="form-label fw-medium"
                        >
                            To
                        </label>

                        <input
                            type="date"
                            name="date_to"
                            id="date_to"
                            class="form-control"
                            value="{{ request('date_to') }}"
                        >

                    </div>


                    <!-- Apply -->
                    <div class="col-lg-1 col-md-6 d-grid">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa-solid fa-filter me-1"></i>
                            Apply
                        </button>

                    </div>


                    <!-- Reset -->
                    <div class="col-lg-2 col-md-6 d-grid">

                        <a
                            href="{{ route('doctor.medical-record.index') }}"
                            class="btn btn-light border"
                        >
                            <i class="fa-solid fa-xmark me-1"></i>
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


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

            <div class="card-footer bg-white border-0 px-4 py-3">

                {{ $medicalRecords->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
