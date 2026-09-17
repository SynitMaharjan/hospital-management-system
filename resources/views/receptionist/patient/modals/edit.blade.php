<div
    class="modal fade"
    id="editPatientModal-{{ $patient->id }}"
    tabindex="-1"
    aria-labelledby="editPatientModalLabel-{{ $patient->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form
                action="{{ route('receptionist.patient.update', $patient) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <div>
                        <h5
                            class="modal-title fw-semibold"
                            id="editPatientModalLabel-{{ $patient->id }}"
                        >
                            Edit Patient
                        </h5>

                        <small class="text-muted">
                            Patient ID: {{ $patient->patient_number }}
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

                    {{-- Personal Information --}}
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-user me-2 text-primary"></i>
                        Personal Information
                    </h6>

                    <div class="row g-3 mb-4">

                        {{-- First Name --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                First Name
                            </label>

                            <input
                                type="text"
                                name="first_name"
                                class="form-control"
                                value="{{ $patient->first_name }}"
                                required
                            >
                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Last Name
                            </label>

                            <input
                                type="text"
                                name="last_name"
                                class="form-control"
                                value="{{ $patient->last_name }}"
                                required
                            >
                        </div>

                        {{-- Patient ID --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Patient ID
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $patient->patient_number }}"
                                readonly
                            >
                        </div>

                        {{-- Date of Birth --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                name="date_of_birth"
                                class="form-control"
                                value="{{ $patient->date_of_birth?->format('Y-m-d') }}"
                            >
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Gender
                            </label>

                            <select
                                name="gender"
                                class="form-select"
                            >
                                <option value="">
                                    Select Gender
                                </option>

                                @foreach(\App\Enums\Gender::cases() as $gender)
                                    <option
                                        value="{{ $gender->value }}"
                                        {{ $patient->gender?->value === $gender->value ? 'selected' : '' }}
                                    >
                                        {{ $gender->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Blood Group --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Blood Group
                            </label>

                            <select
                                name="blood_group"
                                class="form-select"
                            >
                                <option value="">
                                    Select Blood Group
                                </option>

                                @foreach(\App\Enums\BloodGroup::cases() as $bloodGroup)
                                    <option
                                        value="{{ $bloodGroup->value }}"
                                        {{ $patient->blood_group?->value === $bloodGroup->value ? 'selected' : '' }}
                                    >
                                        {{ $bloodGroup->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <hr>

                    {{-- Contact Information --}}
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-address-book me-2 text-primary"></i>
                        Contact Information
                    </h6>

                    <div class="row g-3">

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                value="{{ $patient->phone }}"
                                required
                            >
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ $patient->email }}"
                            >
                        </div>

                    </div>

                     
                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-save me-1"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>