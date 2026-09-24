@extends('layouts.dashboard')

@section('page-title')
Prescriptions
@endsection

@section('dashboard-content')

<div class="container-fluid px-0">


<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

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


{{-- Search & Filters --}}
<form
    method="GET"
    action="{{ route('doctor.prescription.index') }}"
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
            placeholder="Search prescriptions..."
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
                Filter Prescriptions
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
            href="{{ route('doctor.prescription.index') }}"
            class="btn btn-outline-secondary"
            title="Clear search and filters"
        >
            <i class="fa-solid fa-xmark me-1"></i>
            Clear
        </a>

    @endif

</form>


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

        <div class="p-3 border-top">
            {{ $prescriptions->links() }}
        </div>

    @endif

</div>


</div>

@endsection
