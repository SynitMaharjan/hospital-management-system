@extends('layouts.dashboard')

@section('page-title', 'My Medical Records')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>My Medical Records</h4>
</div>

@if($medicalRecords->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fa-solid fa-file-medical fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No medical records found</h5>
            <p class="text-muted">You don't have any medical records at the moment.</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Record Date</th>
                            <th>Doctor</th>
                            <th>Diagnosis</th>
                            <th>Chief Complaint</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicalRecords as $record)
                            <tr>
                                <td>{{ $record->record_date->format('M d, Y') }}</td>
                                <td>
                                    <div class="fw-medium">Dr. {{ $record->doctor->user->name }}</div>
                                    <small class="text-muted">{{ $record->doctor->specialization }}</small>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $record->diagnosis ?? '—' }}</td>
                                <td class="text-truncate text-muted" style="max-width: 200px;">{{ $record->chief_complaint ?? '—' }}</td>
                                <td class="text-end px-4">
                                    <a href="{{ route('patient.medical-record.show', $record->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $medicalRecords->links() }}
            </div>
        </div>
    </div>
@endif
@endsection