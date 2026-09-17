<div
    class="modal fade"
    id="deletePatientModal-{{ $patient->id }}"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    Delete Patient
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>
            </div>

            <div class="modal-body text-center py-4">

                <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3"></i>

                <h5 class="fw-semibold">
                    Are you sure?
                </h5>

                <p class="text-muted mb-0">
                    You are about to delete
                    <strong>{{ $patient->full_name }}</strong>.
                    This action cannot be undone.
                </p>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <form
                    action="{{ route('receptionist.patient.destroy', $patient) }}"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-1"></i>
                        Delete Patient
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>