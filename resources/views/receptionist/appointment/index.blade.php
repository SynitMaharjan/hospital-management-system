@extends('layouts.dashboard')

@section('page-title', 'Appointments')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Manage Appointments</h4>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Create Appointment Form -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Create New Appointment</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('receptionist.appointment.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Patient <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select" required>
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} ({{ $patient->user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Doctor <span class="text-danger">*</span></label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">Select Doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->user->name }} - {{ $doctor->specialization }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date') }}" required min="{{ now()->format('Y-m-d') }}">
                    @error('appointment_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Time <span class="text-danger">*</span></label>
                    <input type="time" name="appointment_time" class="form-control" value="{{ old('appointment_time') }}" required>
                    @error('appointment_time')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control" rows="3" required placeholder="Enter reason for appointment...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-1"></i> Create Appointment
                    </button>
                    <button type="reset" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Existing Appointments -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Appointments</h5>
    </div>
    <div class="card-body p-0">
        @if($appointments->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">No appointments found.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>
                                    <div class="fw-medium">{{ $appointment->patient->user->name }}</div>
                                    <small class="text-muted">{{ $appointment->patient->user->email }}</small>
                                </td>
                                <td>
                                    <div>Dr. {{ $appointment->doctor->user->name }}</div>
                                    <small class="text-muted">{{ $appointment->doctor->specialization }}</small>
                                </td>
                                <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                <td>{{ $appointment->appointment_time->format('h:i A') }}</td>
                                <td>
                                    <span class="badge bg-{{ match($appointment->status->value) {'pending' => 'warning', 'confirmed' => 'success', 'cancelled' => 'danger', 'completed' => 'info', default => 'secondary'} }}">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $appointment->reason }}</td>
                                <td class="text-muted small">{{ $appointment->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>

@endsection