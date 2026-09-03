<div
    class="modal fade"
    id="deleteStaffModal{{ $member->id }}"
    tabindex="-1"
    aria-labelledby="deleteStaffModalLabel{{ $member->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5
                        class="modal-title"
                        id="deleteStaffModalLabel{{ $member->id }}"
                    >
                        Delete Staff
                    </h5>

                    <small class="text-muted">
                        Confirm staff deletion
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
                    Are you sure you want to delete this staff member?
                </p>

                <p class="mb-0">
                    <strong>{{ $member->name }}</strong>
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
                    action="{{ route("admin.staff.destroy", $member) }}"
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
                        Delete Staff
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>