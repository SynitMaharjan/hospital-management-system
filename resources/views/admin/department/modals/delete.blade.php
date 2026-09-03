<div
    class="modal fade"
    id="deleteDepartmentModal{{ $department->id }}"
    tabindex="-1"
    aria-labelledby="deleteDepartmentModalLabel{{ $department->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5
                        class="modal-title"
                        id="deleteDepartmentModalLabel{{ $department->id }}"
                    >
                        Delete Department
                    </h5>

                    <small class="text-muted">
                        Confirm department deletion
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

                <p class="mb-2">
                    Are you sure you want to delete this department?
                </p>

                <p class="mb-0">
                    <strong>{{ $department->name }}</strong>
                </p>

                <small class="text-muted">
                    This action cannot be undone.
                </small>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                <form
                    action="{{ route("admin.department.destroy", $department) }}"
                    method="POST"
                    class="d-inline"
                >

                    @csrf
                    @method("DELETE")

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        <i class="fa-solid fa-trash me-1"></i>
                        Delete Department
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>