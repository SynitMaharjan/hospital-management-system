<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Appointments</h4>
        <p class="text-muted mb-0">
            Manage and schedule patient appointments.
        </p>
    </div>

    <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createAppointmentModal"
    >
        <i class="fas fa-plus me-1"></i>
        New Appointment
    </button>
</div>


<!-- Create Appointment Modal -->
<div
    class="modal fade"
    id="createAppointmentModal"
    tabindex="-1"
    aria-labelledby="createAppointmentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createAppointmentModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Create New Appointment
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <!-- Form -->
            <form
                method="POST"
                action="{{ route('receptionist.appointment.store') }}"
            >
                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <!-- Patient -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Patient
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="patient_id"
                                class="form-select"
                                required
                            >
                                <option value="">Select Patient</option>

                                @foreach ($patients as $patient)
                                    <option
                                        value="{{ $patient->id }}"
                                        {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                    >
                                        {{ $patient->user->name }}
                                        ({{ $patient->user->email }})
                                    </option>
                                @endforeach
                            </select>

                            @error('patient_id')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Doctor -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Doctor
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="doctor_id"
                                class="form-select"
                                required
                            >
                                <option value="">Select Doctor</option>

                                @foreach ($doctors as $doctor)
                                    <option
                                        value="{{ $doctor->id }}"
                                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                    >
                                        Dr. {{ $doctor->user->name }}
                                        - {{ $doctor->specialization }}
                                    </option>
                                @endforeach
                            </select>

                            @error('doctor_id')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Date -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Date
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="appointment_date"
                                class="form-control"
                                value="{{ old('appointment_date') }}"
                                min="{{ now()->format('Y-m-d') }}"
                                required
                            >

                            @error('appointment_date')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Time -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Time
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="time"
                                name="appointment_time"
                                class="form-control"
                                value="{{ old('appointment_time') }}"
                                min="09:00"
                                max="16:30"
                                step="1800"
                                required
                            >

                            @error('appointment_time')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label fw-bold">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                            >
                                <option
                                    value="pending"
                                    {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="confirmed"
                                    {{ old('status') == 'confirmed' ? 'selected' : '' }}
                                >
                                    Confirmed
                                </option>
                            </select>
                        </div>


                        <!-- Reason -->
                        <div class="col-12">
                            <label class="form-label fw-bold">
                                Reason
                                <span class="text-danger">*</span>
                            </label>

                            <textarea
                                name="reason"
                                class="form-control"
                                rows="3"
                                required
                                placeholder="Enter reason for appointment..."
                            >{{ old('reason') }}</textarea>

                            @error('reason')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                </div>


                <!-- Modal Footer -->
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
                        <i class="fas fa-calendar-plus me-1"></i>
                        Create Appointment
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
