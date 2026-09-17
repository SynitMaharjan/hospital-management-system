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

        
    {{-- Search & Filters --}}
    <form
        method="GET"
        action="{{ route('admin.patient.index') }}"
        class="d-flex flex-wrap align-items-center gap-2 mb-4"
    >

        {{-- Search --}}
        <div
            class="input-group"
            style="max-width: 500px;"
        >

            <span class="input-group-text bg-white border-end-0">
                <i class="fa-solid fa-magnifying-glass text-muted"></i>
            </span>

            <input
                type="text"
                name="search"
                class="form-control border-start-0 ps-0"
                placeholder="Search patients..."
                value="{{ request('search') }}"
                autocomplete="off"
            >

        </div>


        {{-- Filter Dropdown --}}
        <div class="dropdown">

            <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                title="Filter"
            >
                <i class="fa-solid fa-filter me-1"></i>
                Filter
            </button>


            <div
                class="dropdown-menu p-3 shadow-sm border-0"
                style="min-width: 240px;"
            >

                <div class="fw-semibold mb-2">
                    Filter Patients
                </div>


                <label
                    for="gender"
                    class="form-label small text-muted mb-1"
                >
                    Gender
                </label>

                <select
                    name="gender"
                    id="gender"
                    class="form-select form-select-sm"
                >

                    <option value="">
                        All Genders
                    </option>

                    @foreach(Gender::cases() as $gender)

                        <option
                            value="{{ $gender->value }}"
                            {{ request('gender') === $gender->value ? 'selected' : '' }}
                        >
                            {{ ucfirst($gender->value) }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- Search Button --}}
        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-magnifying-glass me-1"></i>
            Search
        </button>


        {{-- Clear --}}
        @if(request()->hasAny(['search', 'gender']))

            <a
                href="{{ route('admin.patient.index') }}"
                class="btn btn-outline-secondary"
                title="Clear search and filters"
            >
                <i class="fa-solid fa-xmark me-1"></i>
                Clear
            </a>

        @endif
    </form>



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
                                Blood Group
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
                                        {{ $patient->full_name }}
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->phone }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->date_of_birth  }}
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->gender}}
                                </td>

                                <td class="text-nowrap">
                                    {{ $patient->blood_group}}
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