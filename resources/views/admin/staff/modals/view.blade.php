<!-- View Staff Modal -->

<div
    class="modal fade"
    id="viewStaffModal{{ $member->id }}"
    tabindex="-1"
    aria-labelledby="viewStaffModalLabel{{ $member->id }}"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="viewStaffModalLabel{{ $member->id }}"
                    >
                        Staff Details
                    </h5>

                    <small class="text-muted">
                        View staff account information
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
                            {{ $member->name }}
                        </h4>


                        <!-- Name -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Name
                            </div>

                            <div class="col-md-8">
                                {{ $member->name }}
                            </div>

                        </div>


                        <!-- Username -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Username
                            </div>

                            <div class="col-md-8">
                                {{ $member->username }}
                            </div>

                        </div>


                        <!-- Employee ID -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Employee ID
                            </div>

                            <div class="col-md-8">

                                <span class="font-monospace">
                                    {{ $member->employee_id }}
                                </span>

                            </div>

                        </div>


                        <!-- Email -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Email
                            </div>

                            <div class="col-md-8">
                                {{ $member->email }}
                            </div>

                        </div>


                        <!-- Role -->
                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Role
                            </div>

                            <div class="col-md-8">

                                <span class="badge bg-secondary">
                                    {{ ucfirst($member->role->value) }}
                                </span>

                            </div>

                        </div>


                        <!-- Account Created -->
                        <div class="row">

                            <div class="col-md-4 fw-semibold text-muted">
                                Account Created
                            </div>

                            <div class="col-md-8">
                                {{ $member->created_at->format("M d, Y") }}
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