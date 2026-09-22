@extends('layouts.dashboard')

@section('page-title')
    Prescription
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h4 class="fw-semibold mb-1">
                <i class="fa-solid fa-prescription-bottle-medical text-primary me-2"></i>
                Prescription {{ $prescription->prescription_number }}
            </h4>

            <p class="text-muted mb-0">
                {{ $prescription->patient->full_name }}
                <span class="mx-1">•</span>
                {{ $prescription->prescription_date->format('M d, Y') }}
            </p>
        </div>

        <a
            href="{{ route('doctor.prescription.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Prescriptions
        </a>

    </div>

    <div class="row g-4">

        {{-- Patient Information --}}
        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-bottom py-3">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <h6 class="fw-semibold mb-0">
                            Patient Information
                        </h6>

                    </div>

                </div>

                <div class="card-body">

                    <div class="text-center py-2">

                        @if($prescription->patient->user)

                            <img
                                src="{{ $prescription->patient->user->profile_picture_url }}"
                                alt="{{ $prescription->patient->full_name }}"
                                class="rounded-circle mb-3"
                                style="width: 100px; height: 100px; object-fit: cover;"
                            >

                        @else

                            <div
                                class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto mb-3 flex-shrink-0"
                                style="width: 100px; height: 100px;"
                            >
                                <i class="fa-solid fa-user fs-1"></i>
                            </div>

                        @endif

                        <h5 class="fw-semibold mb-1">
                            {{ $prescription->patient->full_name }}
                        </h5>

                        <div class="text-muted small mb-3">
                            Patient #{{ $prescription->patient->patient_number }}
                        </div>

                        <div class="d-flex flex-wrap justify-content-center gap-2">

                            {{-- Age --}}
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-calendar me-1"></i>

                                {{ $prescription->patient->date_of_birth
                                    ? $prescription->patient->date_of_birth->age . ' years'
                                    : 'Age unknown'
                                }}
                            </span>

                            {{-- Gender --}}
                            @if($prescription->patient->gender)

                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                    <i class="fa-solid fa-venus-mars me-1"></i>
                                    {{ $prescription->patient->gender->value }}
                                </span>

                            @endif

                            {{-- Blood Group --}}
                            @if($prescription->patient->blood_group)

                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                    <i class="fa-solid fa-droplet me-1"></i>
                                    {{ $prescription->patient->blood_group->value }}
                                </span>

                            @endif

                        </div>

                    </div>

                    {{-- Contact Information --}}
                    <div class="border-top mt-4 pt-3">

                        <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                            <i class="fa-solid fa-phone"></i>
                            <span>
                                {{ $prescription->patient->phone ?? 'No phone' }}
                            </span>
                        </div>

                        @if($prescription->patient->email)

                            <div class="d-flex align-items-center gap-2 text-muted small">
                                <i class="fa-solid fa-envelope"></i>
                                <span>
                                    {{ $prescription->patient->email }}
                                </span>
                            </div>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Prescription Information --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-header bg-white border-bottom py-3">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-file-prescription"></i>
                        </div>

                        <h6 class="fw-semibold mb-0">
                            Prescription Details
                        </h6>

                    </div>

                </div>

                <div class="card-body">

                    {{-- Prescription Number --}}
                    <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                        <i class="fa-solid fa-hashtag"></i>

                        <span>
                            {{ $prescription->prescription_number }}
                        </span>
                    </div>

                    {{-- Prescription Date --}}
                    <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                        <i class="fa-solid fa-calendar"></i>

                        <span>
                            {{ $prescription->prescription_date->format('M d, Y') }}
                        </span>
                    </div>

                    {{-- Medicine Count --}}
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="fa-solid fa-pills"></i>

                        <span>
                            {{ $prescription->items->count() }}
                            medicine{{ $prescription->items->count() !== 1 ? 's' : '' }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- Doctor Information --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-header bg-white border-bottom py-3">

                    <div class="d-flex align-items-center gap-2">

                        <div
                            class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;"
                        >
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>

                        <h6 class="fw-semibold mb-0">
                            Doctor Information
                        </h6>

                    </div>

                </div>

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        @if($prescription->doctor->user)

                            <img
                                src="{{ $prescription->doctor->user->profile_picture_url }}"
                                alt="{{ $prescription->doctor->user->name }}"
                                class="rounded-circle flex-shrink-0"
                                style="width: 60px; height: 60px; object-fit: cover;"
                            >

                        @else

                            <div
                                class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 60px; height: 60px;"
                            >
                                <i class="fa-solid fa-user-doctor fs-4"></i>
                            </div>

                        @endif

                        <div>

                            <h6 class="fw-semibold mb-1">
                                {{ $prescription->doctor->user?->name ?? 'Dr. Unknown' }}
                            </h6>

                            <small class="text-muted d-block">
                                {{ $prescription->doctor->specialization ?? 'General Practice' }}
                            </small>

                            @if($prescription->doctor->license_number)

                                <small class="text-muted d-block mt-1">
                                    License: {{ $prescription->doctor->license_number }}
                                </small>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Prescription Content --}}
        <div class="col-12 col-lg-8">

            {{-- Prescribed Medicines --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-bottom py-3">

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">

                        <div class="d-flex align-items-center gap-2">

                            <div
                                class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 40px; height: 40px;"
                            >
                                <i class="fa-solid fa-pills"></i>
                            </div>

                            <h6 class="fw-semibold mb-0">
                                Prescribed Medicines
                            </h6>

                        </div>

                        <span class="text-muted small">
                            {{ $prescription->items->count() }}
                            medicine{{ $prescription->items->count() !== 1 ? 's' : '' }}
                        </span>

                    </div>

                </div>

                <div class="card-body p-0">

                    @if($prescription->items->isEmpty())

                        <div class="text-center py-5">

                            <div class="mb-3">
                                <i class="fa-solid fa-pills fs-1 text-muted opacity-25"></i>
                            </div>

                            <h6 class="fw-semibold mb-1">
                                No medicines prescribed
                            </h6>

                            <p class="text-muted small mb-0">
                                This prescription does not contain any medicines.
                            </p>

                        </div>

                    @else

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th class="ps-4">#</th>
                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Frequency</th>
                                        <th>Duration</th>
                                        <th class="pe-4">Instructions</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($prescription->items as $index => $item)

                                        <tr>

                                            <td class="ps-4 text-muted">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <span class="fw-semibold">
                                                    {{ $item->medicine_name }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $item->dosage }}
                                            </td>

                                            <td>
                                                {{ $item->frequency }}
                                            </td>

                                            <td>
                                                {{ $item->duration }}
                                            </td>

                                            <td class="pe-4 text-muted">
                                                {{ $item->instructions ?: '—' }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Related Medical Record --}}
            @if($prescription->medicalRecord)

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white border-bottom py-3">

                        <div class="d-flex align-items-center gap-2">

                            <div
                                class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 40px; height: 40px;"
                            >
                                <i class="fa-solid fa-file-medical"></i>
                            </div>

                            <h6 class="fw-semibold mb-0">
                                Related Medical Record
                            </h6>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row g-3 mb-3">

                            <div class="col-md-6">

                                <small class="text-muted d-block mb-1">
                                    Record Date
                                </small>

                                <span class="fw-medium">
                                    {{ $prescription->medicalRecord->record_date->format('M d, Y') }}
                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block mb-1">
                                    Diagnosis
                                </small>

                                <span class="fw-medium">
                                    {{ $prescription->medicalRecord->diagnosis ?? 'Not specified' }}
                                </span>

                            </div>

                        </div>

                        <a
                            href="{{ route('doctor.medical-record.show', $prescription->medicalRecord) }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            <i class="fa-solid fa-eye me-1"></i>
                            View Medical Record
                        </a>

                    </div>

                </div>

            @endif


            {{-- Notes --}}
            @if($prescription->notes)

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-header bg-white border-bottom py-3">

                        <div class="d-flex align-items-center gap-2">

                            <div
                                class="bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 40px; height: 40px;"
                            >
                                <i class="fa-solid fa-note-sticky"></i>
                            </div>

                            <h6 class="fw-semibold mb-0">
                                Notes
                            </h6>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="bg-light rounded p-3">
                            {{ $prescription->notes }}
                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection