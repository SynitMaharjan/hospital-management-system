@extends("layouts.dashboard")

@section("page-title")
    Patients
@endsection

@php
    use App\Enums\Gender;
@endphp

@section("dashboard-content")

<div class="container-fluid px-0">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-semibold mb-1">
                Patients
            </h2>

            <p class="text-muted mb-0">
                Manage registered hospital patients
            </p>
        </div>

    </div>


    <!-- Patient Table Card -->
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <!-- Responsive Table -->
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th class="px-4 py-3 text-nowrap">
                                Name
                            </th>

                            <th class="py-3 text-nowrap">
                                Phone
                            </th>

                            <th class="py-3 text-nowrap">
                                Date of Birth
                            </th>

                            <th class="py-3 text-nowrap">
                                Gender
                            </th>

                            <th class="py-3 text-nowrap">
                                Actions
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($patients as $patient)

                            <tr>

                                <td class="px-4 text-nowrap">
                                    <div class="fw-medium">
                                        {{ $patient->user->name }}
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->phone }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->date_of_birth  }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->gender }}
                                </td>

                                <td class="text-nowrap">

                                   <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewPatientModal-{{ $patient->id }}"
                                    >   
                                        <i class="fa-solid fa-eye"></i>
                                   </button>

                                </td>

                            </tr>
                            @include("admin.patient.modals.view", ["patient" => $patient])

                        @empty

                            <tr>
                                <td
                                    colspan="5"
                                    class="text-center py-5 text-muted"
                                >
                                    No patients found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($patients->hasPages())

                <div class="p-3 border-top">

                    {{ $patients->links() }}

                </div>

        @endif

    </div>

</div>

@endsection