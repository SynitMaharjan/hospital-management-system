@extends('layouts.dashboard')

@section('page-title', 'My Medical Records')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
    <h4 class="fw-bold mb-1">My Medical Records</h4>

    <p class="text-muted mb-0">
        View your medical history and records from previous consultations.
    </p>
</div>

</div>

@if($medicalRecords->isEmpty())

{{-- Empty State --}}
<div class="card border-0 shadow-sm">

    <div class="card-body text-center py-5">

        <i class="fa-solid fa-file-medical fa-3x text-muted mb-3"></i>

        <h5 class="fw-semibold mb-2">
            No medical records found
        </h5>

        <p class="text-muted mb-0">
            You don't have any medical records at the moment.
        </p>

    </div>

</div>

@else

{{-- Medical Records --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">
                            Record Date
                        </th>

                        <th>
                            Doctor
                        </th>

                        <th>
                            Diagnosis
                        </th>

                        <th>
                            Chief Complaint
                        </th>

                        <th class="text-end pe-4">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($medicalRecords as $record)

                        <tr>

                            {{-- Record Date --}}
                            <td class="ps-4 text-nowrap">

                                <div class="fw-semibold">
                                    {{ $record->record_date->format('M d, Y') }}
                                </div>

                            </td>


                            {{-- Doctor --}}
                            <td>

                                <div class="fw-semibold">
                                    Dr. {{ $record->doctor->user->name }}
                                </div>

                                <small class="text-muted">
                                    {{ $record->doctor->specialization }}
                                </small>

                            </td>


                            {{-- Diagnosis --}}
                            <td
                                style="min-width: 180px; max-width: 250px;"
                            >

                                <span
                                    class="d-block text-truncate"
                                    title="{{ $record->diagnosis ?? '—' }}"
                                >
                                    {{ $record->diagnosis ?? '—' }}
                                </span>

                            </td>


                            {{-- Chief Complaint --}}
                            <td
                                style="min-width: 180px; max-width: 250px;"
                            >

                                <span
                                    class="d-block text-truncate text-muted"
                                    title="{{ $record->chief_complaint ?? '—' }}"
                                >
                                    {{ $record->chief_complaint ?? '—' }}
                                </span>

                            </td>


                            {{-- Action --}}
                            <td class="text-end pe-4">

                                <a
                                    href="{{ route('patient.medical-record.show', $record->id) }}"
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


        {{-- Pagination --}}
        <div class="card-footer bg-white border-top">

            {{ $medicalRecords->links() }}

        </div>

    </div>

</div>

@endif

@endsection
