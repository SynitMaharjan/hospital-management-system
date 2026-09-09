@if(session("created_staff"))

    @php
        $createdStaff = session("created_staff");
    @endphp

    <!-- Staff Created Modal -->
    <div
        class="modal fade"
        id="staffCreatedModal"
        tabindex="-1"
        aria-labelledby="staffCreatedModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow">

                <!-- Header -->
                <div class="modal-header border-0 px-4 pt-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center"
                            style="width: 46px; height: 46px;"
                        >
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <div>

                            <h5
                                class="modal-title fw-semibold mb-1"
                                id="staffCreatedModalLabel"
                            >
                                Staff Account Created
                            </h5>

                            <p class="text-muted small mb-0">
                                The staff account was created successfully.
                            </p>

                        </div>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <!-- Body -->
                <div class="modal-body px-4 pb-4">

                    <!-- Staff Information -->
                    <div class="bg-light rounded-3 p-3 mb-4">

                        <div class="fw-semibold mb-1">
                            {{ $createdStaff["name"] }}
                        </div>

                        <div class="small text-muted">

                            <span class="me-3">
                                <i class="fa-solid fa-id-badge me-1"></i>
                                {{ $createdStaff["employee_id"] }}
                            </span>

                            <span>
                                <i class="fa-solid fa-user-tag me-1"></i>
                                {{ ucfirst($createdStaff["role"]->value) }}
                            </span>

                        </div>

                    </div>


                    <!-- Credentials Heading -->
                    <div class="mb-3">

                        <h6 class="fw-semibold mb-1">
                            Login Credentials
                        </h6>

                        <p class="text-muted small mb-0">
                            Provide these credentials to the staff member.
                        </p>

                    </div>


                    <!-- Username -->
                    <div class="mb-3">

                        <label class="form-label small fw-medium">
                            Username
                        </label>

                        <div class="input-group">

                            <input
                                type="text"
                                id="createdUsername"
                                class="form-control"
                                value="{{ $createdStaff["username"] }}"
                                readonly
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary copy-btn"
                                data-copy-target="createdUsername"
                            >
                                <i class="fa-regular fa-copy me-1"></i>
                                Copy
                            </button>

                        </div>

                    </div>


                    <!-- Temporary Password -->
                    <div class="mb-3">

                        <label class="form-label small fw-medium">
                            Temporary Password
                        </label>

                        <div class="input-group">

                            <input
                                type="password"
                                id="createdPassword"
                                class="form-control"
                                value="{{ $createdStaff["temporary_password"] }}"
                                readonly
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                id="togglePassword"
                                title="Show password"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-secondary copy-btn"
                                data-copy-target="createdPassword"
                            >
                                <i class="fa-regular fa-copy me-1"></i>
                                Copy
                            </button>

                        </div>

                    </div>


                    <!-- Warning -->
                    <div class="alert alert-warning d-flex gap-2 align-items-start small mb-4">

                        <i class="fa-solid fa-triangle-exclamation mt-1"></i>

                        <div>
                            This is a temporary password. The staff member will be
                            required to change it when they log in for the first time.
                        </div>

                    </div>


                    <!-- Footer -->
                    <div class="d-flex justify-content-end">

                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                        >
                            Done
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endif