@extends('layouts.dashboard')

@section('page-title', 'My Prescriptions')

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>My Prescriptions</h4>
</div>

@if($prescriptions->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fa-solid fa-prescription-bottle-medical fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No prescriptions found</h5>
            <p class="text-muted">You don't have any prescriptions at the moment.</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Prescription Date</th>
                            <th>Doctor</th>
                            <th>Medical Record</th>
                            <th>Medications</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->prescription_date->format('M d, Y') }}</td>
                                <td>
                                    <div class="fw-medium">Dr. {{ $prescription->doctor->user->name }}</div>
                                    <small class="text-muted">{{ $prescription->doctor->specialization }}</small>
                                </td>
                                <td>
                                    @if($prescription->medicalRecord)
                                        #{{ $prescription->medicalRecord->id }} - {{ $prescription->medicalRecord->record_date->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    {{ $prescription->items->count() }} medication{{ $prescription->items->count() !== 1 ? 's' : '' }}
                                </td>
                                <td class="text-end px-4">
                                    <a href="{{ route('patient.prescription.show', $prescription->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $prescriptions->links() }}
            </div>
        </div>
    </div>
@endif
@endsection
