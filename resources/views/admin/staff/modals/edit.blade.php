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

            {{-- Header --}}
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


            {{-- Form --}}
            <form
                action="{{ route('admin.staff.update', $member) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="modal-body px-4 py-4">

                    {{-- Name --}}
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
                            value="{{ old('name', $member->name) }}"
                        >

                        @error('name')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Username --}}
                    <div class="mb-4">
                        <label
                            for="username{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Username
                        </label>

                        <input
                            type="text"
                            id="username{{ $member->id }}"
                            name="username"
                            class="form-control"
                            value="{{ old('username', $member->username) }}"
                            readonly
                        >

                        @error('username')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Employee ID --}}
                    <div class="mb-4">
                        <label
                            for="employee_id{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Employee ID
                        </label>

                        <input
                            type="text"
                            id="employee_id{{ $member->id }}"
                            name="employee_id"
                            class="form-control"
                            value="{{ old('employee_id', $member->employee_id) }}"
                            readonly
                        >

                        @error('employee_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Email --}}
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
                            value="{{ old('email', $member->email) }}"
                        >

                        @error('email')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Phone --}}
                    <div class="mb-4">
                        <label
                            for="phone{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Phone
                        </label>

                        <input
                            type="text"
                            id="phone{{ $member->id }}"
                            name="phone"
                            class="form-control"
                            value="{{ old(
                                'phone',
                                $member->doctor?->phone
                                    ?? $member->nurse?->phone
                            ) }}"
                        >

                        @error('phone')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Role --}}
                    <div class="mb-4">
                        <label
                            for="role{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Role
                        </label>

                        <select
                            id="role{{ $member->id }}"
                            name="role"
                            class="form-select edit-staff-role @error('role') is-invalid @enderror"
                            data-staff-id="{{ $member->id }}"
                        >

                            <option
                                value="{{ Role::DOCTOR->value }}"
                                {{ old(
                                    'role',
                                    $member->role->value
                                ) === Role::DOCTOR->value
                                    ? 'selected'
                                    : '' }}
                            >
                                Doctor
                            </option>

                            <option
                                value="{{ Role::NURSE->value }}"
                                {{ old(
                                    'role',
                                    $member->role->value
                                ) === Role::NURSE->value
                                    ? 'selected'
                                    : '' }}
                            >
                                Nurse
                            </option>

                            <option
                                value="{{ Role::RECEPTIONIST->value }}"
                                {{ old(
                                    'role',
                                    $member->role->value
                                ) === Role::RECEPTIONIST->value
                                    ? 'selected'
                                    : '' }}
                            >
                                Receptionist
                            </option>

                        </select>

                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Department --}}
                    <div
                        class="mb-4 edit-department-field"
                        id="editDepartmentField{{ $member->id }}"
                    >

                        <label
                            for="department_id{{ $member->id }}"
                            class="form-label fw-medium"
                        >
                            Department
                        </label>

                        <select
                            id="department_id{{ $member->id }}"
                            name="department_id"
                            class="form-select"
                        >

                            <option value="">
                                Select Department
                            </option>

                            @foreach($departments as $department)

                                <option
                                    value="{{ $department->id }}"
                                    {{ old(
                                        'department_id',
                                        $member->doctor?->department_id
                                            ?? $member->nurse?->department_id
                                    ) == $department->id
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $department->name }}
                                </option>

                            @endforeach

                        </select>

                        @error('department_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Doctor-specific fields --}}
                    <div id="editDoctorFields{{ $member->id }}">

                        {{-- Specialization --}}
                        <div class="mb-4">

                            <label
                                for="specialization{{ $member->id }}"
                                class="form-label fw-medium"
                            >
                                Specialization
                            </label>

                            <input
                                type="text"
                                id="specialization{{ $member->id }}"
                                name="specialization"
                                class="form-control"
                                value="{{ old(
                                    'specialization',
                                    $member->doctor?->specialization
                                ) }}"
                            >

                            @error('specialization')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- License Number --}}
                        <div class="mb-2">

                            <label
                                for="license_number{{ $member->id }}"
                                class="form-label fw-medium"
                            >
                                License Number
                            </label>

                            <input
                                type="text"
                                id="license_number{{ $member->id }}"
                                name="license_number"
                                class="form-control"
                                value="{{ old(
                                    'license_number',
                                    $member->doctor?->license_number
                                ) }}"
                            >

                            @error('license_number')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
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

