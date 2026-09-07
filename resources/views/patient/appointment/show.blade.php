@extends('layouts.dashboard')

@section('page-title', 'Appointment Details')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Appointment Details</h4>
    <a href="{{ route('patient.appointment.index') }}" class="btn btn-outline-secondary">
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
                <label class="form-label text-muted fw-bold">Doctor</label>
                <div class="fw-medium">Dr. {{ $appointment->doctor->user->name }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-bold">Department</label>
                <div>{{ $appointment->doctor->department->name }}</div>
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

        <div class="mb-3">
            <label class="form-label text-muted fw-bold">Created At</label>
            <div class="text-muted">{{ $appointment->created_at->format('F d, Y h:i A') }}</div>
        </div>
    </div>
</div>

@endsection