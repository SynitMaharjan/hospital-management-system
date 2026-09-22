@extends('layouts.dashboard')

@section('page-title')
    Prescriptions
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-semibold mb-1">
                <i class="fa-solid fa-prescription-bottle-medical text-primary me-2"></i>
                Prescriptions
            </h4>

            <p class="text-muted mb-0">
                Medications prescribed by you
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

    {{-- Search and Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <form
                method="GET"
                action="{{ route('doctor.prescription.index') }}"
                class="row g-3"
            >

                <div class="col-12 col-md-4">
                    <label for="search" class="form-label fw-semibold">
                        Search
                    </label>

                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Patient name, number, phone, prescription #..."
                            value="{{ request('search') }}"
                        >

                        <button
                            type="submit"
                            class="btn btn-outline-secondary"
                        >
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-2">
                    <label for="date_from" class="form-label fw-semibold">
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

                <div class="col-12 col-sm-6 col-md-2">
                    <label for="date_to" class="form-label fw-semibold">
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

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        <i class="fa-solid fa-filter me-1"></i>
                        Apply
                    </button>
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <a
                        href="{{ route('doctor.prescription.index') }}"
                        class="btn btn-outline-secondary w-100"
                    >
                        <i class="fa-solid fa-xmark me-1"></i>
                        Reset
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- Prescriptions --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fw-semibold mb-1">
                        Prescription Records
                    </h6>

                    <small class="text-muted">
                        {{ $prescriptions->total() }}
                        prescription{{ $prescriptions->total() !== 1 ? 's' : '' }}
                        found
                    </small>
                </div>

            </div>
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Patient #</th>
                        <th>Prescription #</th>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th class="text-center">Medicines</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($prescriptions as $prescription)

                        <tr>

                            {{-- Patient --}}
                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    @if($prescription->patient->user)

                                        <img
                                            src="{{ $prescription->patient->user->profile_picture_url }}"
                                            alt="{{ $prescription->patient->full_name }}"
                                            class="rounded-circle"
                                            width="44"
                                            height="44"
                                        >

                                    @else

                                        <div
                                            class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                            style="width: 44px; height: 44px;"
                                        >
                                            <i class="fa-solid fa-user"></i>
                                        </div>

                                    @endif

                                    <div>
                                        <h6 class="fw-medium mb-0">
                                            {{ $prescription->patient->full_name }}
                                        </h6>

                                        <small class="text-muted">
                                            {{ $prescription->patient->phone ?? 'No phone' }}
                                        </small>
                                    </div>

                                </div>

                            </td>

                            {{-- Patient Number --}}
                            <td>
                                <span class="fw-medium">
                                    {{ $prescription->patient->patient_number }}
                                </span>
                            </td>

                            {{-- Prescription Number --}}
                            <td>
                                <code>
                                    {{ $prescription->prescription_number }}
                                </code>
                            </td>

                            {{-- Date --}}
                            <td>
                                <span class="fw-medium">
                                    {{ $prescription->prescription_date->format('M d, Y') }}
                                </span>
                            </td>

                            {{-- Diagnosis --}}
                            <td>

                                @if($prescription->medicalRecord)

                                    <div
                                        class="text-truncate"
                                        style="max-width: 250px;"
                                        title="{{ $prescription->medicalRecord->diagnosis ?? '' }}"
                                    >
                                        {{ $prescription->medicalRecord->diagnosis ?? 'Record #' . $prescription->medicalRecord->id }}
                                    </div>

                                @else

                                    <span class="text-muted">
                                        No linked record
                                    </span>

                                @endif

                            </td>

                            {{-- Medicine Count --}}
                            <td class="text-center">

                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                    <i class="fa-solid fa-pills me-1"></i>
                                    {{ $prescription->items->count() }}
                                </span>

                            </td>

                            {{-- Action --}}
                            <td class="pe-4 text-end">

                                <a
                                    href="{{ route('doctor.prescription.show', $prescription) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="View Prescription"
                                >
                                    <i class="fa-solid fa-eye me-1"></i>
                                    View
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">

                                <div class="text-muted">

                                    <div class="mb-3">
                                        <i class="fa-solid fa-prescription-bottle-medical fs-1 opacity-25"></i>
                                    </div>

                                    <h6 class="fw-semibold mb-1">
                                        No prescriptions found
                                    </h6>

                                    <p class="small mb-3">
                                        Try adjusting your search or date filters.
                                    </p>

                                    <a
                                        href="{{ route('doctor.prescription.create') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        <i class="fa-solid fa-plus me-1"></i>
                                        Create Prescription
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    @if($prescriptions->hasPages())
        <div class="mt-4">
            {{ $prescriptions->links() }}
        </div>
    @endif

</div>

@endsection