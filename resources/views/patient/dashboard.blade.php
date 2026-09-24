@extends('layouts.dashboard')

@section('page-title')
Patient Dashboard
@endsection

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Patient Dashboard</h4>


<a href="{{ route('patient.appointment.create') }}" class="btn btn-outline-primary">
    Book Appointment
</a>


</div>

<div class="row">


<!-- Patient Information -->
<div class="col-md-4 mb-4">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
            <h5 class="fw-semibold mb-0">Patient Information</h5>
        </div>

        <div class="card-body px-4">
            <div class="d-flex flex-column align-items-center text-center py-3">

                @if($patient->user)
                    <img
                        src="{{ $patient->user->profile_picture_url }}"
                        alt="{{ $patient->full_name }}"
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
                    {{ $patient->full_name }}
                </h5>

                <div class="text-muted mb-3">
                    Patient #{{ $patient->patient_number }}
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-2">

                    @if($patient->date_of_birth)
                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                            <i class="fa-solid fa-calendar me-1"></i>
                            {{ $patient->date_of_birth->age }} years
                        </span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                            <i class="fa-solid fa-calendar-xmark me-1"></i>
                            Age unknown
                        </span>
                    @endif

                    @if($patient->gender)
                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                            <i class="fa-solid fa-venus-mars me-1"></i>
                            {{ $patient->gender->value }}
                        </span>
                    @endif

                    @if($patient->blood_group)
                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                            <i class="fa-solid fa-droplet me-1"></i>
                            {{ $patient->blood_group->value }}
                        </span>
                    @endif

                </div>

                <div class="w-100 text-start mt-4 pt-3 border-top">

                    <p class="text-muted small mb-2">
                        <i class="fa-solid fa-phone me-2"></i>
                        {{ $patient->phone ?: 'No phone' }}
                    </p>

                    @if($patient->email)
                        <p class="text-muted small mb-0">
                            <i class="fa-solid fa-envelope me-2"></i>
                            {{ $patient->email }}
                        </p>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>


<!-- Upcoming Appointment -->
<div class="col-md-4 mb-4">
    <div class="card border-0 shadow-sm h-100">

        <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
            <h5 class="fw-semibold mb-0">Upcoming Appointment</h5>
        </div>

        <div class="card-body px-4">

            @if($upcomingAppointment)

                <div>

                    <h6 class="fw-semibold text-primary mb-2">
                        Appointment #{{ $upcomingAppointment->id }}
                    </h6>

                    <div class="text-muted small">
                        <i class="fa-solid fa-calendar-day me-2"></i>
                        {{ $upcomingAppointment->appointment_date->format('M d, Y') }}
                        at
                        {{ $upcomingAppointment->appointment_time->format('h:i A') }}
                    </div>

                    <div class="mt-2">
                        <i class="fa-solid fa-user-doctor me-2"></i>
                        Dr. {{ $upcomingAppointment->doctor->user->name }}
                        <br>

                        <small class="text-muted">
                            {{ $upcomingAppointment->doctor->specialization }}
                        </small>
                    </div>

                    <div class="mt-2">
                        <i class="fa-solid fa-building me-2"></i>
                        {{ $upcomingAppointment->doctor->department->name }}
                    </div>

                    <div class="mt-2">
                        <i class="fa-solid fa-comment-medical me-2"></i>
                        {{ $upcomingAppointment->reason }}
                    </div>

                    <div class="mt-3">
                        <span class="badge bg-{{
                            match($upcomingAppointment->status->value) {
                                'pending' => 'warning',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'info',
                                default => 'secondary'
                            }
                        }} fs-6">
                            {{ ucfirst($upcomingAppointment->status->value) }}
                        </span>
                    </div>

                    <div class="mt-3">
                        <a
                            href="{{ route('patient.appointment.show', $upcomingAppointment->id) }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            View Details
                        </a>
                    </div>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fa-solid fa-calendar-check fa-2x text-muted mb-3"></i>

                    <p class="text-muted mb-3">
                        No upcoming appointments
                    </p>

                    <a
                        href="{{ route('patient.appointment.create') }}"
                        class="btn btn-sm btn-outline-primary"
                    >
                        Book Appointment
                    </a>

                </div>

            @endif

        </div>
    </div>
</div>


<!-- Recent Medical Record -->
<div class="col-md-4 mb-4">
    <div class="card border-0 shadow-sm h-100">

        <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
            <h5 class="fw-semibold mb-0">Recent Medical Record</h5>
        </div>

        <div class="card-body px-4">

            @if($recentMedicalRecord)

                <div>

                    <h6 class="fw-semibold text-primary mb-2">
                        Record #{{ $recentMedicalRecord->id }}
                    </h6>

                    <div class="text-muted small">
                        <i class="fa-regular fa-calendar me-1"></i>
                        {{ $recentMedicalRecord->record_date->format('M d, Y') }}
                    </div>

                    <div class="mt-2">
                        <i class="fa-solid fa-user-doctor me-2"></i>
                        Dr. {{ $recentMedicalRecord->doctor->user->name }}
                    </div>

                    @if($recentMedicalRecord->diagnosis)
                        <div class="mt-3">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            <strong>Diagnosis:</strong>
                            {{ $recentMedicalRecord->diagnosis }}
                        </div>
                    @endif

                    @if($recentMedicalRecord->chief_complaint)
                        <div class="mt-3">
                            <i class="fa-solid fa-comment-medical me-2"></i>
                            <strong>Chief Complaint:</strong>
                            {{ $recentMedicalRecord->chief_complaint }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <a
                            href="{{ route('patient.medical-record.show', $recentMedicalRecord->id) }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            View Full Record
                        </a>
                    </div>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fa-solid fa-file-medical fa-2x text-muted mb-3"></i>

                    <p class="text-muted mb-0">
                        No medical records available
                    </p>

                </div>

            @endif

        </div>
    </div>
</div>


</div>

<!-- Recent Prescription -->

<div class="row">


<div class="col-12 mb-4">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
            <h5 class="fw-semibold mb-0">Recent Prescription</h5>
        </div>

        <div class="card-body px-4">

            @if($recentPrescription)

                <div>

                    <h6 class="fw-semibold text-primary mb-2">
                        Prescription #{{ $recentPrescription->id }}
                    </h6>

                    <div class="text-muted small">
                        <i class="fa-regular fa-calendar me-1"></i>
                        {{ $recentPrescription->prescription_date->format('M d, Y') }}
                    </div>

                    <div class="mt-2">
                        <i class="fa-solid fa-user-doctor me-2"></i>
                        Dr. {{ $recentPrescription->doctor->user->name }}
                    </div>

                    <div class="mt-2">
                        <i class="fa-solid fa-prescription-bottle-medical me-2"></i>
                        {{ $recentPrescription->items->count() }}
                        medication{{ $recentPrescription->items->count() !== 1 ? 's' : '' }}
                    </div>

                    @if($recentPrescription->notes)
                        <div class="mt-3">
                            <i class="fa-solid fa-sticky-note me-2"></i>
                            <strong>Notes:</strong>
                            {{ $recentPrescription->notes }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <a
                            href="{{ route('patient.prescription.show', $recentPrescription->id) }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            View Full Prescription
                        </a>
                    </div>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="fa-solid fa-prescription-bottle-medical fa-2x text-muted mb-3"></i>

                    <p class="text-muted mb-0">
                        No prescriptions available
                    </p>

                </div>

            @endif

        </div>
    </div>

</div>


</div>

@endsection
