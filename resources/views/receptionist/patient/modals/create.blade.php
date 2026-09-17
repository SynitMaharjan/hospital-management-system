<div
    class="modal fade"
    id="createPatientModal"
    tabindex="-1"
    aria-labelledby="createPatientModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5 class="modal-title" id="createPatientModalLabel">
                        Register Patient
                    </h5>

                    <small class="text-muted">
                        Create a new hospital patient record
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
                method="POST"
                action="{{ route('receptionist.patient.store') }}"
            >

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        {{-- First Name --}}
                        <div class="col-md-6">

                            <label
                                for="first_name"
                                class="form-label"
                            >
                                First Name
                            </label>

                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                class="form-control"
                                value="{{ old('first_name') }}"
                                required
                            >

                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6">

                            <label
                                for="last_name"
                                class="form-label"
                            >
                                Last Name
                            </label>

                            <input
                                type="text"
                                name="last_name"
                                id="last_name"
                                class="form-control"
                                value="{{ old('last_name') }}"
                                required
                            >

                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">

                            <label
                                for="phone"
                                class="form-label"
                            >
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                class="form-control"
                                value="{{ old('phone') }}"
                                required
                            >

                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email
                                <span class="text-muted">(Optional)</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="{{ old('email') }}"
                            >

                        </div>

                        {{-- Date of Birth --}}
                        <div class="col-md-6">

                            <label
                                for="date_of_birth"
                                class="form-label"
                            >
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                name="date_of_birth"
                                id="date_of_birth"
                                class="form-control"
                                value="{{ old('date_of_birth') }}"
                            >

                        </div>

                        {{-- Gender --}}
                        <div class="col-md-6">

                            <label
                                for="gender"
                                class="form-label"
                            >
                                Gender
                            </label>

                            <select
                                name="gender"
                                id="gender"
                                class="form-select"
                            >

                                <option value="">
                                    Select Gender
                                </option>

                                @foreach(\App\Enums\Gender::cases() as $gender)

                                    <option
                                        value="{{ $gender->value }}"
                                        {{ old('gender') === $gender->value ? 'selected' : '' }}
                                    >
                                        {{ $gender->value }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Blood Group --}}
                        <div class="col-md-6">

                            <label
                                for="blood_group"
                                class="form-label"
                            >
                                Blood Group
                            </label>

                            <select
                                name="blood_group"
                                id="blood_group"
                                class="form-select"
                            >

                                <option value="">
                                    Select Blood Group
                                </option>

                                @foreach(\App\Enums\BloodGroup::cases() as $bloodGroup)

                                    <option
                                        value="{{ $bloodGroup->value }}"
                                        {{ old('blood_group') === $bloodGroup->value ? 'selected' : '' }}
                                    >
                                        {{ $bloodGroup->value }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-user-plus me-1"></i>
                        Register Patient
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>