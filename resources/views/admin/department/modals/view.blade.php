<div
    class="modal fade"
    id="viewDepartmentModal{{ $department->id }}"
    tabindex="-1"
    aria-labelledby="viewDepartmentModalLabel{{ $department->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5
                        class="modal-title"
                        id="viewDepartmentModalLabel{{ $department->id }}"
                    >
                        Department Details
                    </h5>

                    <small class="text-muted">
                        View department information
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="card border-0">

                    <div class="card-body">

                        <h4 class="mb-4">
                            {{ $department->name }}
                        </h4>


                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Department ID
                            </div>

                            <div class="col-md-8">
                                <span class="font-monospace">
                                    {{ $department->department_number}}
                                </span>
                            </div>

                        </div>


                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Department Name
                            </div>

                            <div class="col-md-8">
                                {{ $department->name }}
                            </div>

                        </div>


                        <div class="row mb-3">

                            <div class="col-md-4 fw-semibold text-muted">
                                Description
                            </div>

                            <div class="col-md-8">
                                {{ $department->description ?? "No description provided." }}
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-4 fw-semibold text-muted">
                                Account Created
                            </div>

                            <div class="col-md-8">
                                {{ $department->created_at->format("M d, Y") }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


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