@extends('layouts.dashboard')

@section('page-title')
    Prescriptions
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-1">

                <div class="text-primary fs-4">
                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                </div>

                <h2 class="fw-semibold mb-0">
                    Prescriptions
                </h2>

            </div>

            <p class="text-muted mb-0">
                Prescriptions and medications issued to your patients
            </p>
        </div>


        <a
            href="{{ route('doctor.prescription.create') }}"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-plus me-1"></i>
            New Prescription
        </a>

    </div>


    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <form
                method="GET"
                action="{{ route('doctor.prescription.index') }}"
            >

                <div class="row g-3 align-items-end">

                    <!-- Search -->
                    <div class="col-lg-5 col-md-6">

                        <label
                            for="search"
                            class="form-label fw-medium"
                        >
                            Search Prescriptions
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
                                placeholder="Patient name, number, phone, prescription #..."
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
                            href="{{ route('doctor.prescription.index') }}"
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


    <!-- Prescriptions Card -->
    <div class="card border-0 shadow-sm">

        <!-- Card Header -->
        <div class="card-header bg-white border-0 px-4 py-3">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

                <div>

                    <h5 class="fw-semibold mb-1">
                        Prescription Records
                    </h5>

                    <small class="text-muted">
                        Medication and prescription information recorded for patients
                    </small>

                </div>


                @if($prescriptions->total() > 0)

                    <span class="badge bg-primary-subtle text-primary px-3 py-2">

                        {{ $prescriptions->total() }}

                        {{ $prescriptions->total() === 1 ? 'Prescription' : 'Prescriptions' }}

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
                            Prescription #
                        </th>

                        <th class="py-3">
                            Date
                        </th>

                        <th class="py-3">
                            Diagnosis
                        </th>

                        <th class="py-3 text-center">
                            Medicines
                        </th>

                        <th class="pe-4 text-end py-3">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($prescriptions as $prescription)

                        <tr>

                            <!-- Patient -->
                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    @if($prescription->patient->user)

                                        <img
                                            src="{{ $prescription->patient->user->profile_picture_url }}"
                                            alt="{{ $prescription->patient->full_name }}"
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
                                            {{ $prescription->patient->full_name }}
                                        </div>

                                        <small class="text-muted">
                                            <i class="fa-solid fa-phone fa-xs me-1"></i>
                                            {{ $prescription->patient->phone ?? 'No phone' }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <!-- Patient Number -->
                            <td>

                                <span class="fw-medium">
                                    {{ $prescription->patient->patient_number }}
                                </span>

                            </td>


                            <!-- Prescription Number -->
                            <td>

                                <span class="fw-medium">
                                    {{ $prescription->prescription_number }}
                                </span>

                            </td>


                            <!-- Date -->
                            <td>

                                <div class="fw-medium">

                                    <i class="fa-regular fa-calendar me-1 text-muted"></i>

                                    {{ $prescription->prescription_date->format('M d, Y') }}

                                </div>

                            </td>


                            <!-- Diagnosis -->
                            <td>

                                @if($prescription->medicalRecord)

                                    <div
                                        class="text-truncate"
                                        style="max-width: 220px;"
                                        title="{{ $prescription->medicalRecord->diagnosis ?? '' }}"
                                    >
                                        {{ $prescription->medicalRecord->diagnosis ?? 'Record #' . $prescription->medicalRecord->id }}
                                    </div>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            <!-- Medicine Count -->
                            <td class="text-center">

                                <span class="badge bg-primary-subtle text-primary px-3 py-2">

                                    <i class="fa-solid fa-pills me-1"></i>

                                    {{ $prescription->items->count() }}

                                </span>

                            </td>


                            <!-- Action -->
                            <td class="pe-4 text-end">

                                <a
                                    href="{{ route('doctor.prescription.show', $prescription) }}"
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
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="py-3">

                                    <div
                                        class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 64px; height: 64px;"
                                    >
                                        <i class="fa-solid fa-prescription-bottle-medical fs-4"></i>
                                    </div>

                                    <h6 class="fw-semibold mb-1">
                                        No prescriptions found
                                    </h6>

                                    <p class="text-muted small mb-3">
                                        No prescriptions match your current search or filters.
                                    </p>


                                    @if(request()->hasAny(['search', 'date_from', 'date_to']))

                                        <a
                                            href="{{ route('doctor.prescription.index') }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            <i class="fa-solid fa-rotate-left me-1"></i>
                                            Clear Filters
                                        </a>

                                    @else

                                        <a
                                            href="{{ route('doctor.prescription.create') }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i class="fa-solid fa-plus me-1"></i>
                                            Create Prescription
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
        @if($prescriptions->hasPages())

            <div class="card-footer bg-white border-0 px-4 py-3">

                {{ $prescriptions->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
