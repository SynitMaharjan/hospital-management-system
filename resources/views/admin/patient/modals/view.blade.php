<!-- View Patient Modal -->

<div
    class="modal fade"
    id="viewPatientModal-{{ $patient->id }}"
    tabindex="-1"
    aria-labelledby="viewPatientModalLabel-{{ $patient->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="viewPatientModalLabel-{{ $patient->id }}"
                    >
                        Patient Details
                    </h5>

                    <small class="text-muted">
                        View patient information
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <!-- Modal Body -->
            <div class="modal-body">

                <div class="card border-0">

                    <div class="card-body">

                        <h4 class="mb-4">
                            {{ $patient->user->name }}
                        </h4>


                        <!-- Patient ID -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Patient ID
                            </div>

                            <div class="col-md-8">

                                <span class="font-monospace">
                                    {{ $patient->id }}
                                </span>

                            </div>

                        </div>


                        <!-- Patient Name -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Patient Name
                            </div>

                            <div class="col-md-8">
                                {{ $patient->user->name }}
                            </div>

                        </div>


                        <!-- Patient Email -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Patient Email
                            </div>

                            <div class="col-md-8">
                                {{ $patient->user->email }}
                            </div>

                        </div>


                        <!-- Phone Number -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Phone Number
                            </div>

                            <div class="col-md-8">
                                {{ $patient->phone }}
                            </div>

                        </div>


                        <!-- Date of Birth -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Date of Birth
                            </div>

                            <div class="col-md-8">
                                {{ $patient->date_of_birth }}
                            </div>

                        </div>


                        <!-- Gender -->
                        <div class="row">

                            <div class="col-md-4 fw-semibold text-muted">
                                Gender
                            </div>

                            <div class="col-md-8">
                                {{ ucfirst($patient->gender) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Modal Footer -->
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