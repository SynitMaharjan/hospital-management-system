<div
    class="modal fade"
    id="viewPatientModal-{{ $patient->id }}"
    tabindex="-1"
    aria-labelledby="viewPatientModalLabel-{{ $patient->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">


    <div class="modal-content border-0 shadow">

        {{-- Header --}}

        <div class="modal-header">

            <div>
                <h5
                    class="modal-title fw-semibold"
                    id="viewPatientModalLabel-{{ $patient->id }}"
                >
                    Patient Details
                </h5>

                <small class="text-muted">
                    Patient ID:
                    P-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}
                </small>
            </div>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>

        </div>

        {{-- Body --}}

        <div class="modal-body">

            {{-- Personal Information --}}

            <h6 class="fw-semibold mb-3">
                <i class="fa-solid fa-user me-2 text-primary"></i>
                Personal Information
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <small class="text-muted d-block">Full Name</small>
                    <span class="fw-medium">
                        {{ $patient->full_name }}
                    </span>
                </div>

                <div class="col-md-6">
                    <small class="text-muted d-block">Username</small>
                    <span>
                        {{ $patient->patient_number }}
                    </span>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Date of Birth</small>
                    <span>
                        {{ $patient->date_of_birth?->format('F d, Y') ?? 'N/A' }}
                    </span>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Age</small>
                    <span>
                        {{ $patient->date_of_birth?->age ?? 'N/A' }}
                    </span>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Gender</small>
                    <span>
                        {{ $patient->gender?->value ?? 'N/A' }}
                    </span>
                </div>

            </div>

            <hr>

            {{-- Contact Information --}}

            <h6 class="fw-semibold mb-3">
                <i class="fa-solid fa-address-book me-2 text-primary"></i>
                Contact Information
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <small class="text-muted d-block">Phone</small>
                    <span>
                        {{ $patient->phone ?? 'N/A' }}
                    </span>
                </div>

                <div class="col-md-6">
                    <small class="text-muted d-block">Email</small>
                    <span>
                        {{ $patient->email ?? 'N/A' }}
                    </span>
                </div>

            </div>

            <hr>

            {{-- Registration Information --}}

            <h6 class="fw-semibold mb-3">
                <i class="fa-solid fa-clipboard-user me-2 text-primary"></i>
                Registration Information
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <small class="text-muted d-block">Patient ID</small>
                    <span>
                        P-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <div class="col-md-6">
                    <small class="text-muted d-block">Registered On</small>
                    <span>
                        {{ $patient->created_at?->format('F d, Y') ?? 'N/A' }}
                    </span>
                </div>

            </div>

            <hr>

            {{-- Emergency Contact --}}

            <h6 class="fw-semibold mb-3">
                <i class="fa-solid fa-truck-medical me-2 text-danger"></i>
                Emergency Contact
            </h6>

            <div class="row g-3">

                <div class="col-md-4">
                    <small class="text-muted d-block">Name</small>
                    <span>N/A</span>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Phone</small>
                    <span>N/A</span>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Relationship</small>
                    <span>N/A</span>
                </div>

            </div>

        </div>

        {{-- Footer --}}

        <div class="modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
            >
                Close
            </button>

        </div>

    </div>

</div>


</div>
