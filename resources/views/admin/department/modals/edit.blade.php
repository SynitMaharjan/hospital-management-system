<div
    class="modal fade"
    id="editDepartmentModal{{ $department->id }}"
    tabindex="-1"
    aria-labelledby="editDepartmentModalLabel{{ $department->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5
                        class="modal-title"
                        id="editDepartmentModalLabel{{ $department->id }}"
                    >
                        Edit Department
                    </h5>

                    <small class="text-muted">
                        Update department information
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
                action="{{ route("admin.department.update", $department) }}"
                method="POST"
            >

                @csrf
                @method("PUT")

                <div class="modal-body">

                    <div class="mb-3">

                        <label
                            for="name{{ $department->id }}"
                            class="form-label"
                        >
                            Department Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name{{ $department->id }}"
                            class="form-control"
                            value="{{ $department->name }}"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="description{{ $department->id }}"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description{{ $department->id }}"
                            class="form-control"
                            rows="4"
                        >{{ $department->description }}</textarea>

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
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>