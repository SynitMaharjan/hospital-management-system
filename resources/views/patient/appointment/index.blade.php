@extends('layouts.dashboard')

@section('page-title', 'My Appointments')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>My Appointments</h4>
</div>

@if($appointments->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No appointments found</h5>
            <p class="text-muted">You don't have any appointments scheduled at the moment.</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>
                                    <div class="fw-medium">Dr. {{ $appointment->doctor->user->name }}</div>
                                    <small class="text-muted">{{ $appointment->doctor->specialization }}</small>
                                </td>
                                <td>{{ $appointment->doctor->department->name }}</td>
                                <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                <td>{{ $appointment->appointment_time->format('h:i A') }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $appointment->reason }}</td>
                                <td>
                                    <span class="badge bg-{{ match($appointment->status->value) {'pending' => 'warning', 'confirmed' => 'success', 'cancelled' => 'danger', 'completed' => 'info', default => 'secondary'} }} fs-6">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('patient.appointment.show', $appointment->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
@endif

@endsection