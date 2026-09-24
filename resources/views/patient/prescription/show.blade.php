@extends('layouts.dashboard')

@section('page-title')
Prescription
@endsection

@section('dashboard-content')
<div class="container-fluid px-4">

<!-- Page Header -->
<div class="d-flex flex-column flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <div class="d-flex align-items-center gap-2 mb-1">

            <div class="text-primary fs-4">
                <i class="fa-solid fa-prescription-bottle-medical"></i>
            </div>

            <h2 class="fw-semibold mb-0">
                Prescription
            </h2>

        </div>

        <p class="text-muted mb-0">
            {{ $prescription->patient->full_name }}
            <span class="mx-1">•</span>
            {{ $prescription->prescription_date->format('M d, Y') }}
        </p>

    </div>

    <div class="d-flex gap-2 flex-wrap">

        <a
            href="{{ route('patient.prescription.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back
        </a>

    </div>

</div>


<div class="row g-4">

    <!-- Patient & Prescription Information -->
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

                    @if($prescription->patient->user)

                        <img
                            src="{{ $prescription->patient->user->profile_picture_url }}"
                            alt="{{ $prescription->patient->full_name }}"
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
                        {{ $prescription->patient->full_name }}
                    </h5>

                    <div class="text-muted mb-3">
                        Patient #{{ $prescription->patient->patient_number }}
                    </div>


                    <div class="d-flex flex-wrap justify-content-center gap-2">

                        @if($prescription->patient->date_of_birth)

                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-calendar me-1"></i>
                                {{ $prescription->patient->date_of_birth->age }} years
                            </span>

                        @else

                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                <i class="fa-solid fa-calendar-xmark me-1"></i>
                                Age unknown
                            </span>

                        @endif


                        @if($prescription->patient->gender)

                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-venus-mars me-1"></i>
                                {{ $prescription->patient->gender->value }}
                            </span>

                        @endif


                        @if($prescription->patient->blood_group)

                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="fa-solid fa-droplet me-1"></i>
                                {{ $prescription->patient->blood_group->value }}
                            </span>

                        @endif

                    </div>


                    <div class="w-100 text-start mt-4 pt-3 border-top">

                        <p class="text-muted small mb-2">

                            <i class="fa-solid fa-phone me-2"></i>

                            {{ $prescription->patient->phone ?: 'No phone' }}

                        </p>


                        @if($prescription->patient->email)

                            <p class="text-muted small mb-0">

                                <i class="fa-solid fa-envelope me-2"></i>

                                {{ $prescription->patient->email }}

                            </p>

                        @endif

                    </div>

                </div>

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

                    @if($prescription->doctor->user)

                        <img
                            src="{{ $prescription->doctor->user->profile_picture_url }}"
                            alt="{{ $prescription->doctor->user->name }}"
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
                            {{ $prescription->doctor->user?->name ?? 'Dr. Unknown' }}
                        </h6>

                        <small class="text-muted d-block">
                            {{ $prescription->doctor->specialization }}
                        </small>

                        <small class="text-muted">
                            License: {{ $prescription->doctor->license_number }}
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Prescription Details -->
    <div class="col-lg-8">

        <!-- Prescription Info Card -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                <h5 class="fw-semibold mb-0">
                    Prescription Details
                </h5>

            </div>


            <div class="card-body px-4">

                <div class="mb-3">

                    <h6 class="fw-semibold text-primary mb-2">
                        Prescription Number
                    </h6>

                    <div>
                        {{ $prescription->prescription_number }}
                    </div>

                </div>

                <div class="mb-3">

                    <h6 class="fw-semibold text-primary mb-2">
                        Date
                    </h6>

                    <div>
                        {{ $prescription->prescription_date->format('M d, Y') }}
                    </div>

                </div>

                @if($prescription->notes)

                    <div class="mb-3">

                        <h6 class="fw-semibold text-primary mb-2">
                            Notes
                        </h6>

                        <div class="p-3 bg-light rounded">
                            {{ $prescription->notes }}
                        </div>

                    </div>

                @endif

                <!-- Medications List -->
                <div class="mt-4">

                    <h6 class="fw-semibold text-primary mb-2">
                        Medications
                    </h6>

                    @if($prescription->items->isEmpty())

                        <p class="text-muted">
                            No medications listed.
                        </p>

                    @else

                        <div class="list-group">

                            @foreach($prescription->items as $item)

                                <div class="list-group-item">
                                    <strong>{{ $item->name }}</strong>
                                    @if($item->dosage)
                                        <br>
                                        <small class="text-muted">Dosage: {{ $item->dosage }}</small>
                                    @endif
                                    @if($item->frequency)
                                        <br>
                                        <small class="text-muted">Frequency: {{ $item->frequency }}</small>
                                    @endif
                                    @if($item->duration)
                                        <br>
                                        <small class="text-muted">Duration: {{ $item->duration }}</small>
                                    @endif
                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </div>


        <!-- Medical Record & Appointment -->
        @if($prescription->medicalRecord)

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                        <h5 class="fw-semibold mb-0">
                            Associated Medical Record
                        </h5>

                    </div>


                    <div class="card-body px-4">

                        @if($prescription->medicalRecord->appointment)

                            <div class="mb-3">

                                <h6 class="fw-semibold text-primary mb-2">
                                    Appointment
                                </h6>

                                <div>
                                    {{ $prescription->medicalRecord->appointment->appointment_date->format('M d, Y') }} at {{ $prescription->medicalRecord->appointment->appointment_time->format('g:i A') }}
                                </div>

                            </div>

                            @if($prescription->medicalRecord->appointment->reason)

                                <div class="mb-3">

                                    <h6 class="fw-semibold text-primary mb-2">
                                        Reason for Visit
                                    </h6>

                                    <div>
                                        {{ $prescription->medicalRecord->appointment->reason }}
                                    </div>

                                </div>

                            @endif

                        @endif

                        @if($prescription->medicalRecord->diagnosis)

                            <div class="mb-3">

                                <h6 class="fw-semibold text-primary mb-2">
                                    Diagnosis
                                </h6>

                                <div>
                                    {{ $prescription->medicalRecord->diagnosis }}
                                </div>

                            </div>

                        @endif

                        @if($prescription->medicalRecord->chief_complaint)

                            <div class="mb-3">

                                <h6 class="fw-semibold text-primary mb-2">
                                    Chief Complaint
                                </h6>

                                <div>
                                    {{ $prescription->medicalRecord->chief_complaint }}
                                </div>

                            </div>

                        @endif

                        @if($prescription->medicalRecord->symptoms)

                            <div class="mb-3">

                            <h6 class="fw-semibold text-primary mb-2">
                                    Symptoms
                                </h6>

                                <div>
                                    {{ $prescription->medicalRecord->symptoms }}
                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @endif


        <!-- Previous Prescriptions -->
        @if($previousPrescriptions->isNotEmpty())

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                        <h5 class="fw-semibold mb-0">
                            Previous Prescriptions
                        </h5>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th>Prescription Date</th>
                                        <th>Doctor</th>
                                        <th>Medications</th>
                                        <th class="text-end">Action</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($previousPrescriptions as $prescription)

                                        <tr>

                                            <td>{{ $prescription->prescription_date->format('M d, Y') }}</td>
                                            <td>
                                                <div class="fw-medium">Dr. {{ $prescription->doctor->user->name }}</div>
                                                <small class="text-muted">{{ $prescription->doctor->specialization }}</small>
                                            </td>
                                            <td>
                                                {{ $prescription->items->count() }} medication{{ $prescription->items->count() !== 1 ? 's' : '' }}
                                            </td>
                                            <td class="text-end px-4">

                                                <a
                                                    href="{{ route('patient.prescription.show', $prescription->id) }}"
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

            </div>

        @endif

    </div>

</div>

</div>

@endsection
