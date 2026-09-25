@extends('layouts.dashboard')

@section('page-title', 'My Prescriptions')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">


<div>
    <h4 class="fw-bold mb-1">My Prescriptions</h4>

    <p class="text-muted mb-0">
        View your prescribed medications and prescription history.
    </p>
</div>


</div>

@if($prescriptions->isEmpty())


{{-- Empty State --}}
<div class="card border-0 shadow-sm">

    <div class="card-body text-center py-5">

        <i class="fa-solid fa-prescription-bottle-medical fa-3x text-muted mb-3"></i>

        <h5 class="fw-semibold mb-2">
            No prescriptions found
        </h5>

        <p class="text-muted mb-0">
            You don't have any prescriptions at the moment.
        </p>

    </div>

</div>


@else


{{-- Prescriptions --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">
                            Prescription Date
                        </th>

                        <th>
                            Doctor
                        </th>

                        <th>
                            Medical Record
                        </th>

                        <th>
                            Medications
                        </th>

                        <th class="text-end pe-4">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($prescriptions as $prescription)

                        <tr>

                            {{-- Prescription Date --}}
                            <td class="ps-4 text-nowrap">

                                <div class="fw-semibold">
                                    {{ $prescription->prescription_date->format('M d, Y') }}
                                </div>

                            </td>


                            {{-- Doctor --}}
                            <td>

                                <div class="fw-semibold">
                                    Dr. {{ $prescription->doctor->user->name }}
                                </div>

                                <small class="text-muted">
                                    {{ $prescription->doctor->specialization }}
                                </small>

                            </td>


                            {{-- Medical Record --}}
                            <td class="text-nowrap">

                                @if($prescription->medicalRecord)

                                    <div class="fw-semibold">
                                        Medical Record
                                    </div>

                                    <small class="text-muted">
                                        {{ $prescription->medicalRecord->record_date->format('M d, Y') }}
                                    </small>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Medications --}}
                            <td>

                                <span class="badge bg-primary-subtle text-primary">

                                    {{ $prescription->items->count() }}

                                    medication{{ $prescription->items->count() !== 1 ? 's' : '' }}

                                </span>

                            </td>


                            {{-- Action --}}
                            <td class="text-end pe-4">

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


        {{-- Pagination --}}
        <div class="card-footer bg-white border-top">

            {{ $prescriptions->links() }}

        </div>

    </div>

</div>


@endif

@endsection
