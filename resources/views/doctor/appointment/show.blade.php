@extends('layouts.dashboard')

@section('page-title', 'Appointment Details')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Appointment Details</h4>
    <a href="{{ route('doctor.appointment.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Appointments
    </a>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Appointment #{{ $appointment->id }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Status</label>
                <div>
                    <span class="badge bg-{{ match($appointment->status->value) {'pending' => 'warning', 'confirmed' => 'success', 'cancelled' => 'danger', 'completed' => 'info', default => 'secondary'} }} fs-6">
                        {{ ucfirst($appointment->status->value) }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <label class="form-label text-muted fw-bold">Appointment ID</label>
                <div class="text-muted">#{{ $appointment->id }}</div>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Patient</label>
                <div class="fw-medium">{{ $appointment->patient->full_name }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Patient Email</label>
                <div>{{ $appointment->patient->email }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Patient Phone</label>
                <div>{{ $appointment->patient->phone ?? 'Not provided' }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Date of Birth</label>
                <div>{{ $appointment->patient->date_of_birth?->format('F d, Y') ?? 'Not provided' }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Date</label>
                <div>{{ $appointment->appointment_date->format('F d, Y') }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Time</label>
                <div>{{ $appointment->appointment_time->format('h:i A') }}</div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted fw-bold">Reason</label>
            <div>{{ $appointment->reason }}</div>
        </div>

        @if($appointment->status->value === 'pending')
        <hr>
        <div class="d-flex gap-2">
            <form action="{{ route('doctor.appointment.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check me-1"></i> Confirm Appointment
                </button>
            </form>

            <form action="{{ route('doctor.appointment.update', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                    <i class="fas fa-times me-1"></i> Cancel Appointment
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection