<!-- Create Staff Modal -->
@php
    use App\Enums\Role;
@endphp

<div
    class="modal fade"
    id="createStaffModal"
    tabindex="-1"
    aria-labelledby="createStaffModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <!-- Modal Header -->
            <div class="modal-header px-4 py-3">

                <div>
                    <h5 class="modal-title fw-semibold mb-1" id="createStaffModalLabel">
                        Create Staff Account
                    </h5>

                    <p class="text-muted small mb-0">
                        Add a new staff member to the hospital system.
                    </p>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <!-- Modal Body -->
            <div class="modal-body px-4 py-4">

                <form
                    action="{{ route("admin.staff.store") }}"
                    method="POST"
                >

                    @csrf


                    <!-- Name -->
                    <div class="mb-3">

                        <label for="name" class="form-label fw-medium">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old("name") }}"
                            class="form-control @error("name") is-invalid @enderror"
                            placeholder="Enter staff member's name"
                            autocomplete="name"
                        >

                        @error("name")
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <!-- Username -->
                    <div class="mb-3">

                        <label for="username" class="form-label fw-medium">
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old("username") }}"
                            class="form-control @error("username") is-invalid @enderror"
                            placeholder="Enter login username"
                            autocomplete="username"
                        >

                        @error("username")
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <!-- Employee ID -->
                    <div class="mb-3">

                        <label for="employee_id" class="form-label fw-medium">
                            Employee ID
                        </label>

                        <input
                            type="text"
                            id="employee_id"
                            name="employee_id"
                            value="{{ old("employee_id") }}"
                            class="form-control @error("employee_id") is-invalid @enderror"
                            placeholder="e.g. EMP001"
                        >

                        @error("employee_id")
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <!-- Email -->
                    <div class="mb-3">

                        <label for="email" class="form-label fw-medium">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old("email") }}"
                            class="form-control @error("email") is-invalid @enderror"
                            placeholder="staff@hospital.com"
                            autocomplete="email"
                        >

                        @error("email")
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <!-- Role -->
                    <div class="mb-3">

                        <label for="role" class="form-label fw-medium">
                            Staff Role
                        </label>

                        <select
                            id="role"
                            name="role"
                            class="form-select @error("role") is-invalid @enderror"
                        >

                            <option value="">
                                Select Staff Role
                            </option>

                            <option
                                value="{{ Role::DOCTOR->value }}"
                                {{ old("role") === Role::DOCTOR->value ? "selected" : "" }}
                            >
                                Doctor
                            </option>

                            <option
                                value="{{ Role::NURSE->value }}"
                                {{ old("role") === Role::NURSE->value ? "selected" : "" }}
                            >
                                Nurse
                            </option>

                            <option
                                value="{{ Role::RECEPTIONIST->value }}"
                                {{ old("role") === Role::RECEPTIONIST->value ? "selected" : "" }}
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


                    <!-- Footer -->
                    <div class="d-flex justify-content-end gap-2 pt-3">

                        <button
                            type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa-solid fa-user-plus me-1"></i>
                            Create Staff
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>