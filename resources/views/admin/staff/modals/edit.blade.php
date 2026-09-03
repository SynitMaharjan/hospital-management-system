@php
    use App\Enums\Role;
@endphp

<div
    class="modal fade"
    id="editStaffModal{{ $member->id }}"
    tabindex="-1"
    aria-labelledby="editStaffModalLabel{{ $member->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header px-4 py-3">

                <div>
                    <h5
                        class="modal-title"
                        id="editStaffModalLabel{{ $member->id }}"
                    >
                        Edit Staff
                    </h5>

                    <small class="text-muted">
                        Update staff information
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <!-- Form -->
            <form
                action="{{ route("admin.staff.update", $member) }}"
                method="POST"
            >

                @csrf
                @method("PUT")


                <!-- Body -->
                <div class="modal-body px-4 py-4">

                    <!-- Name -->
                    <div class="mb-4">

                        <label
                            for="name{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            id="name{{ $member->id }}"
                            name="name"
                            class="form-control"
                            value="{{ old("name", $member->name) }}"
                        >

                        @error("name")
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <!-- Email -->
                    <div class="mb-4">

                        <label
                            for="email{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email{{ $member->id }}"
                            name="email"
                            class="form-control"
                            value="{{ old("email", $member->email) }}"
                        >

                        @error("email")
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <!-- Role -->
                    <div class="mb-2">

                        <label
                            for="role{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Role
                        </label>

                        <select
                            id="role{{ $member->id }}"
                            name="role"
                            class="form-select @error("role") is-invalid @enderror"
                        >

                            <option
                                value="{{ Role::DOCTOR->value }}"
                                {{ old("role", $member->role->value) === Role::DOCTOR->value ? "selected" : "" }}
                            >
                                Doctor
                            </option>

                            <option
                                value="{{ Role::NURSE->value }}"
                                {{ old("role", $member->role->value) === Role::NURSE->value ? "selected" : "" }}
                            >
                                Nurse
                            </option>

                            <option
                                value="{{ Role::RECEPTIONIST->value }}"
                                {{ old("role", $member->role->value) === Role::RECEPTIONIST->value ? "selected" : "" }}
                            >
                                Receptionist
                            </option>

                        </select>

                        @error("role")
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <!-- Footer -->
                <div class="modal-footer px-4 py-3">

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