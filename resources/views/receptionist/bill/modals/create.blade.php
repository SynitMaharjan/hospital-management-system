<div
    class="modal fade"
    id="createBillModal"
    tabindex="-1"
    aria-labelledby="createBillModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="createBillModalLabel">

                    <i class="fa-solid fa-file-invoice me-2"></i>
                    Create New Bill

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <form
                method="POST"
                action="{{ route('receptionist.bill.store') }}"
            >

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        {{-- Patient --}}

                        <div class="col-md-6">

                            <label class="form-label fw-bold">

                                Patient
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="patient_id"
                                id="bill_patient_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Patient
                                </option>

                                @foreach ($patients as $patient)

                                    <option
                                        value="{{ $patient->id }}"
                                        {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                    >

                                        {{ $patient->full_name }}

                                        ({{ $patient->email ?? 'No email provided' }})

                                    </option>

                                @endforeach

                            </select>

                            @error('patient_id')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Appointment --}}

                        <div class="col-md-6">

                            <label class="form-label fw-bold">

                                Appointment

                            </label>

                            <select
                                name="appointment_id"
                                id="bill_appointment_id"
                                class="form-select"
                                disabled
                            >

                                <option value="">
                                    Select a patient first
                                </option>

                            </select>

                            @error('appointment_id')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                            <small class="text-muted">

                                Only appointments belonging to the selected patient will be shown.

                            </small>

                        </div>


                        {{-- Billing Date --}}

                        <div class="col-md-6">

                            <label class="form-label fw-bold">

                                Billing Date
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="date"
                                name="billing_date"
                                class="form-control"
                                value="{{ old('billing_date', now()->toDateString()) }}"
                                required
                            >

                            @error('billing_date')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Discount --}}

                        <div class="col-md-6">

                            <label class="form-label fw-bold">

                                Discount

                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    name="discount_percentage"
                                    class="form-control"
                                    value="{{ old('discount_percentage', 0) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="Enter discount percentage"
                                >

                                <span class="input-group-text">
                                    %
                                </span>

                            </div>

                            @error('discount_percentage')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                            <small class="text-muted">

                                Enter a discount between 0% and 100%.

                            </small>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >

                        <i class="fa-solid fa-xmark me-1"></i>
                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-file-invoice me-1"></i>
                        Create Bill

                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const patientSelect =
        document.getElementById('bill_patient_id');

    const appointmentSelect =
        document.getElementById('bill_appointment_id');


    function resetAppointments(message) {

        appointmentSelect.innerHTML = '';

        const option =
            document.createElement('option');

        option.value = '';
        option.textContent = message;

        appointmentSelect.appendChild(option);

        appointmentSelect.disabled = true;
    }


    function loadAppointments(patientId) {

        if (!patientId) {

            resetAppointments(
                'Select a patient first'
            );

            return;
        }


        appointmentSelect.innerHTML = '';

        const loadingOption =
            document.createElement('option');

        loadingOption.value = '';
        loadingOption.textContent =
            'Loading appointments...';

        appointmentSelect.appendChild(
            loadingOption
        );

        appointmentSelect.disabled = true;


        fetch(
            `/receptionist/bill/patient/${patientId}/appointments`
        )
            .then(response => {

                if (!response.ok) {

                    throw new Error(
                        'Failed to load appointments.'
                    );

                }

                return response.json();

            })
            .then(appointments => {

                appointmentSelect.innerHTML = '';


                const defaultOption =
                    document.createElement('option');

                defaultOption.value = '';
                defaultOption.textContent =
                    'No Appointment';

                appointmentSelect.appendChild(
                    defaultOption
                );


                appointments.forEach(function (appointment) {

                    const option =
                        document.createElement('option');

                    option.value =
                        appointment.id;


                    const doctorName =
                        appointment.doctor &&
                        appointment.doctor.user
                            ? appointment.doctor.user.name
                            : 'Unknown Doctor';


                    option.textContent =
                        `${appointment.appointment_number} - ` +
                        `with Dr. ${doctorName} ` +
                        `(${appointment.appointment_date} at ` +
                        `${appointment.appointment_time})`;


                    appointmentSelect.appendChild(
                        option
                    );

                });


                appointmentSelect.disabled = false;


                if (appointments.length === 0) {

                    appointmentSelect.innerHTML = '';

                    const noAppointmentOption =
                        document.createElement('option');

                    noAppointmentOption.value = '';

                    noAppointmentOption.textContent =
                        'No appointments found';

                    appointmentSelect.appendChild(
                        noAppointmentOption
                    );

                }

            })
            .catch(error => {

                console.error(
                    'Error loading appointments:',
                    error
                );

                resetAppointments(
                    'Unable to load appointments'
                );

            });

    }


    patientSelect.addEventListener(
        'change',
        function () {

            loadAppointments(this.value);

        }
    );


    if (patientSelect.value) {

        loadAppointments(
            patientSelect.value
        );

    } else {

        resetAppointments(
            'Select a patient first'
        );

    }

});

</script>

@endpush
