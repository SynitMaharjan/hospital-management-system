@extends('layouts.dashboard')

@section('page-title', 'Appointments')

@section('dashboard-content')

@if (session('success')) <div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button> </div>
@endif

@if ($errors->any()) <div class="alert alert-danger alert-dismissible fade show" role="alert"> <ul class="mb-0">
@foreach ($errors->all() as $error) <li>{{ $error }}</li>
@endforeach </ul> <button type="button" class="btn-close" data-bs-dismiss="alert"></button> </div>
@endif

<!-- Page Header -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Appointments</h4>
        <p class="text-muted mb-0">
            Manage and schedule patient appointments.
        </p>
    </div>

<button
    type="button"
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#createAppointmentModal"
>
    <i class="fas fa-plus me-1"></i>
    New Appointment
</button>

</div>

<!-- Create Appointment Modal -->

<div
    class="modal fade"
    id="createAppointmentModal"
    tabindex="-1"
    aria-labelledby="createAppointmentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="createAppointmentModalLabel">
                <i class="fas fa-calendar-plus me-2"></i>
                Create New Appointment
            </h5>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>

        <form
            method="POST"
            action="{{ route('receptionist.appointment.store') }}"
        >
            @csrf

            <div class="modal-body">
                <div class="row g-3">

                    <!-- Patient -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Patient <span class="text-danger">*</span>
                        </label>

                        <select name="patient_id" class="form-select" required>
                            <option value="">Select Patient</option>

                            @foreach ($patients as $patient)
                                <option
                                    value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                >
                                    {{ $patient->full_name }}
                                    ({{ $patient->email ?? 'No email provided' }})
                                </option>
                            @endforeach
                        </select>

                        @error('patient_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Doctor -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Doctor <span class="text-danger">*</span>
                        </label>

                        <select name="doctor_id" class="form-select" required>
                            <option value="">Select Doctor</option>

                            @foreach ($doctors as $doctor)
                                <option
                                    value="{{ $doctor->id }}"
                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                >
                                    Dr. {{ $doctor->user->name }}
                                    - {{ $doctor->specialization }}
                                </option>
                            @endforeach
                        </select>

                        @error('doctor_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Date <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="appointment_date"
                            class="form-control"
                            value="{{ old('appointment_date') }}"
                            min="{{ now()->format('Y-m-d') }}"
                            required
                        >

                        @error('appointment_date')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Time -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Time <span class="text-danger">*</span>
                        </label>

                        <input
                            type="time"
                            name="appointment_time"
                            class="form-control"
                            value="{{ old('appointment_time') }}"
                            min="09:00"
                            max="16:30"
                            step="1800"
                            required
                        >

                        @error('appointment_time')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            Status
                        </label>

                        <select name="status" class="form-select">
                            <option
                                value="pending"
                                {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="confirmed"
                                {{ old('status') == 'confirmed' ? 'selected' : '' }}
                            >
                                Confirmed
                            </option>
                        </select>
                    </div>

                    <!-- Reason -->
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            Reason <span class="text-danger">*</span>
                        </label>

                        <textarea
                            name="reason"
                            class="form-control"
                            rows="3"
                            placeholder="Enter reason for appointment..."
                            required
                        >{{ old('reason') }}</textarea>

                        @error('reason')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-plus me-1"></i>
                    Create Appointment
                </button>
            </div>

        </form>
    </div>
</div>

</div>

<!-- Existing Appointments -->

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            All Appointments
        </h5>
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

                            <td>
                                {{ $appointment->appointment_number }}
                            </td>

                            <td>
                                <div class="fw-medium">
                                    {{ $appointment->patient->full_name }} 
                                </div>

                                <small class="text-muted">
                                    {{ $appointment->patient->email }}
                                </small>
                            </td>

                            <td>
                                <div>
                                    Dr. {{ $appointment->doctor->user->name }}
                                </div>

                                <small class="text-muted">
                                    {{ $appointment->doctor->specialization }}
                                </small>
                            </td>

                            <td>
                                {{ $appointment->appointment_date->format('M d, Y') }}
                            </td>

                            <td>
                                {{ $appointment->appointment_time->format('h:i A') }}
                            </td>

                            <td>
                                <span class="badge bg-{{
                                    match($appointment->status->value) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        'completed' => 'info',
                                        default => 'secondary'
                                    }
                                }}">
                                    {{ ucfirst($appointment->status->value) }}
                                </span>
                            </td>

                            <td
                                class="text-truncate"
                                style="max-width: 200px;"
                            >
                                {{ $appointment->reason }}
                            </td>

                            <td class="text-muted small">
                                {{ $appointment->created_at->format('M d, Y H:i') }}
                            </td>

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

<!-- Reopen modal after validation error -->

@if ($errors->any()) <script>
document.addEventListener('DOMContentLoaded', function () {
const modalElement = document.getElementById('createAppointmentModal');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    });
</script>

@endif

@endsection
