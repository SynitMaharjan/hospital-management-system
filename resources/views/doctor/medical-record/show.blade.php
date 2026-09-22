@extends('layouts.dashboard')

@section('page-title')
Medical Record
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
                Medical Record
            </h2>

        </div>

        <p class="text-muted mb-0">
            {{ $medicalRecord->patient->full_name }}
            <span class="mx-1">•</span>
            {{ $medicalRecord->record_date->format('M d, Y') }}
        </p>

    </div>


    <div class="d-flex gap-2 flex-wrap">

        @can('update', $medicalRecord)

            <a
                href="{{ route('doctor.medical-record.edit', $medicalRecord) }}"
                class="btn btn-outline-primary"
            >
                <i class="fa-solid fa-pen-to-square me-1"></i>
                Edit
            </a>

        @endcan


        <a
            href="{{ route('doctor.medical-record.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back
        </a>

    </div>

</div>


<div class="row g-4">

    <!-- Patient & Appointment Information -->
    <div class="col-lg-4">

        <!-- Patient Information -->
        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                <h5 class="fw-semibold mb-0">
                    Patient Information
                </h5>

            </div>


            <div class="card-body px-4">

                <div class="d-flex flex-column align-items-center text-center py-3">

                    @if($medicalRecord->patient->user)

                        <img
                            src="{{ $medicalRecord->patient->user->profile_picture_url }}"
                            alt="{{ $medicalRecord->patient->full_name }}"
                            class="rounded-circle mb-3 object-fit-cover"
                            width="100"
                            height="100"
                        >

                    @else

                        <div
                            class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center text-primary mb-3"
                            style="width: 100px; height: 100px;"
                        >
                            <i class="fa-solid fa-user fs-1"></i>
                        </div>

                    @endif


                    <h5 class="fw-medium mb-1">
                        {{ $medicalRecord->patient->full_name }}
                    </h5>

                    <div class="text-muted mb-3">
                        Patient #{{ $medicalRecord->patient->patient_number }}
                    </div>


                    <div class="d-flex flex-wrap justify-content-center gap-2">

                        @if($medicalRecord->patient->date_of_birth)

                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-calendar me-1"></i>
                                {{ $medicalRecord->patient->date_of_birth->age }} years
                            </span>

                        @else

                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                <i class="fa-solid fa-calendar-xmark me-1"></i>
                                Age unknown
                            </span>

                        @endif


                        @if($medicalRecord->patient->gender)

                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-venus-mars me-1"></i>
                                {{ $medicalRecord->patient->gender->value }}
                            </span>

                        @endif


                        @if($medicalRecord->patient->blood_group)

                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-droplet me-1"></i>
                                {{ $medicalRecord->patient->blood_group->value }}
                            </span>

                        @endif

                    </div>


                    <div class="w-100 text-start mt-4 pt-3 border-top">

                        <p class="text-muted small mb-2">

                            <i class="fa-solid fa-phone me-2"></i>

                            {{ $medicalRecord->patient->phone ?: 'No phone' }}

                        </p>


                        @if($medicalRecord->patient->email)

                            <p class="text-muted small mb-0">

                                <i class="fa-solid fa-envelope me-2"></i>

                                {{ $medicalRecord->patient->email }}

                            </p>

                        @endif

                    </div>

                </div>


                @if($medicalRecord->appointment)

                    <hr class="my-4">


                    @php

                        $appointmentStatus = $medicalRecord->appointment->status->value;

                        $statusClass = match ($appointmentStatus) {
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            'confirmed' => 'primary',
                            default => 'warning',
                        };

                    @endphp


                    <div>

                        <h6 class="fw-semibold mb-3">
                            Appointment Details
                        </h6>


                        <div class="text-muted small">

                            <p class="mb-2">

                                <i class="fa-solid fa-calendar-day me-2"></i>

                                {{ $medicalRecord->appointment->appointment_date->format('M d, Y') }}

                                at

                                {{ $medicalRecord->appointment->appointment_time->format('g:i A') }}

                            </p>


                            <p class="mb-2">

                                <i class="fa-solid fa-hashtag me-2"></i>

                                {{ $medicalRecord->appointment->appointment_number }}

                            </p>


                            <p class="mb-2">

                                <i class="fa-solid fa-flag me-2"></i>

                                Status:

                                <span class="badge bg-{{ $statusClass }} ms-1">
                                    {{ ucfirst($appointmentStatus) }}
                                </span>

                            </p>


                            @if($medicalRecord->appointment->reason)

                                <p class="mb-0">

                                    <i class="fa-solid fa-comment-medical me-2"></i>

                                    {{ Str::limit($medicalRecord->appointment->reason, 80) }}

                                </p>

                            @endif

                        </div>

                    </div>

                @endif

            </div>

        </div>


        <!-- Doctor Information -->
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                <h5 class="fw-semibold mb-0">
                    Doctor Information
                </h5>

            </div>


            <div class="card-body px-4">

                <div class="d-flex align-items-center gap-3">

                    @if($medicalRecord->doctor->user)

                        <img
                            src="{{ $medicalRecord->doctor->user->profile_picture_url }}"
                            alt="{{ $medicalRecord->doctor->user->name }}"
                            class="rounded-circle object-fit-cover"
                            width="60"
                            height="60"
                        >

                    @else

                        <div
                            class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center text-primary"
                            style="width: 60px; height: 60px;"
                        >
                            <i class="fa-solid fa-user-doctor fs-4"></i>
                        </div>

                    @endif


                    <div>

                        <h6 class="fw-medium mb-1">
                            {{ $medicalRecord->doctor->user?->name ?? 'Dr. Unknown' }}
                        </h6>

                        <small class="text-muted d-block">
                            {{ $medicalRecord->doctor->specialization }}
                        </small>

                        <small class="text-muted">
                            License: {{ $medicalRecord->doctor->license_number }}
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Clinical Details -->
    <div class="col-lg-8">

        <!-- Clinical Details Card -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white border-0 px-4 pt-4 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">

                <div class="d-flex align-items-center gap-2">

                    <div class="text-primary">
                        <i class="fa-solid fa-stethoscope fs-5"></i>
                    </div>

                    <h5 class="fw-semibold mb-0">
                        Clinical Details
                    </h5>

                </div>


                <div class="text-muted small">

                    <i class="fa-regular fa-calendar me-1"></i>

                    {{ $medicalRecord->record_date->format('M d, Y') }}

                </div>

            </div>


            <div class="card-body px-4 pb-4">

                @if($medicalRecord->chief_complaint)

                    <div class="mb-4">

                        <h6 class="fw-semibold text-primary mb-2">
                            Chief Complaint / Visit Reason
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $medicalRecord->chief_complaint }}
                        </div>

                    </div>

                @endif


                @if($medicalRecord->symptoms)

                    <div class="mb-4">

                        <h6 class="fw-semibold text-primary mb-2">
                            Symptoms
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $medicalRecord->symptoms }}
                        </div>

                    </div>

                @endif


                @if($medicalRecord->diagnosis)

                    <div class="mb-4">

                        <h6 class="fw-semibold text-primary mb-2">
                            Diagnosis
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $medicalRecord->diagnosis }}
                        </div>

                    </div>

                @endif


                @if($medicalRecord->examination)

                    <div class="mb-4">

                        <h6 class="fw-semibold text-primary mb-2">
                            Examination Findings
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $medicalRecord->examination }}
                        </div>

                    </div>

                @endif


                @if($medicalRecord->treatment)

                    <div class="mb-4">

                        <h6 class="fw-semibold text-primary mb-2">
                            Treatment Plan
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $medicalRecord->treatment }}
                        </div>

                    </div>

                @endif


                @if($medicalRecord->notes)

                    <div class="mb-0">

                        <h6 class="fw-semibold text-primary mb-2">
                            Additional Notes
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $medicalRecord->notes }}
                        </div>

                    </div>

                @endif


                @if(
                    !$medicalRecord->chief_complaint &&
                    !$medicalRecord->symptoms &&
                    !$medicalRecord->diagnosis &&
                    !$medicalRecord->examination &&
                    !$medicalRecord->treatment &&
                    !$medicalRecord->notes
                )

                    <div class="text-center py-5 text-muted">

                        <i class="fa-solid fa-file-circle-question fs-1 opacity-25"></i>

                        <p class="mt-3 mb-0">
                            No clinical details recorded
                        </p>

                    </div>

                @endif

            </div>

        </div>


        <!-- Prescriptions -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white border-0 px-4 pt-4 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">

                <div class="d-flex align-items-center gap-2">

                    <div class="text-primary">
                        <i class="fa-solid fa-prescription-bottle-medical fs-5"></i>
                    </div>

                    <h5 class="fw-semibold mb-0">
                        Prescriptions
                    </h5>

                </div>


                <a
                    href="{{ route('doctor.prescription.create', ['medical_record_id' => $medicalRecord->id]) }}"
                    class="btn btn-sm btn-primary"
                >
                    <i class="fa-solid fa-plus me-1"></i>
                    Add Prescription
                </a>

            </div>


            <div class="card-body p-0">

                @if($medicalRecord->prescriptions->isEmpty())

                    <div class="text-center py-4">

                        <i class="fa-solid fa-prescription-bottle-medical fs-1 text-muted opacity-50"></i>

                        <p class="text-muted mt-2 mb-0">
                            No prescriptions for this record
                        </p>

                    </div>

                @else

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4">
                                        Prescription #
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Medicines
                                    </th>

                                    <th class="text-end px-4">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($medicalRecord->prescriptions as $prescription)

                                    <tr>

                                        <td class="px-4 fw-medium">
                                            {{ $prescription->prescription_number }}
                                        </td>

                                        <td>
                                            {{ $prescription->prescription_date->format('M d, Y') }}
                                        </td>

                                        <td>

                                            @php
                                                $medicineCount = $prescription->items->count();
                                            @endphp

                                            <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                                {{ $medicineCount }}
                                                medicine{{ $medicineCount !== 1 ? 's' : '' }}
                                            </span>

                                        </td>

                                        <td class="text-end px-4">

                                            <a
                                                href="{{ route('doctor.prescription.show', $prescription) }}"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                <i class="fa-solid fa-eye me-1"></i>
                                                View
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>


        <!-- Previous Medical Records -->
        @if($previousRecords->isNotEmpty())

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                    <div class="d-flex align-items-center gap-2">

                        <div class="text-primary">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>

                        <h5 class="fw-semibold mb-0">
                            Previous Medical Records
                        </h5>

                    </div>

                    <small class="text-muted">
                        Previous records for this patient
                    </small>

                </div>


                <div class="card-body p-0 mt-3">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4">
                                        Record Date
                                    </th>

                                    <th>
                                        Diagnosis
                                    </th>

                                    <th>
                                        Chief Complaint
                                    </th>

                                    <th class="text-end px-4">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($previousRecords as $record)

                                    <tr>

                                        <td class="px-4">
                                            {{ $record->record_date->format('M d, Y') }}
                                        </td>

                                        <td
                                            class="text-truncate"
                                            style="max-width: 200px;"
                                        >
                                            {{ $record->diagnosis ?? '—' }}
                                        </td>

                                        <td
                                            class="text-truncate text-muted"
                                            style="max-width: 200px;"
                                        >
                                            {{ $record->chief_complaint ?? '—' }}
                                        </td>

                                        <td class="text-end px-4">

                                            <a
                                                href="{{ route('doctor.medical-record.show', $record) }}"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                <i class="fa-solid fa-eye me-1"></i>
                                                View
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

</div>

@endsection
