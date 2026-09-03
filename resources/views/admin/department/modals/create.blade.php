<div
    class="modal fade"
    id="createDepartmentModal"
    tabindex="-1"
    aria-labelledby="createDepartmentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5
                        class="modal-title"
                        id="createDepartmentModalLabel"
                    >
                        Create Department
                    </h5>

                    <small class="text-muted">
                        Add a new hospital department
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <form
                action="{{ route("admin.department.store") }}"
                method="POST"
            >
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label
                            for="name"
                            class="form-label"
                        >
                            Department Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            placeholder="e.g. Cardiology"
                            value="{{ old("name") }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label
                            for="description"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            rows="4"
                            placeholder="Enter a brief description of the department"
                        >{{ old("description") }}</textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-plus me-1"></i>
                        Create Department
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>