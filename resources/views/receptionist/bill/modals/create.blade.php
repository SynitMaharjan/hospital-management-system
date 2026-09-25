<div
    class="modal fade"
    id="createBillModal"
    tabindex="-1"
    aria-labelledby="createBillModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">


    <div class="modal-content">

        {{-- Modal Header --}}
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


        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('receptionist.bill.store') }}"
        >

            @csrf


            <div class="modal-body">

                <div class="row g-3">

                    {{-- Patient --}}
                    <div class="col-md-6">

                        <label
                            for="bill_patient_id"
                            class="form-label fw-bold"
                        >
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

                                    @if($patient->email)
                                        — {{ $patient->email }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        @error('patient_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Search by patient name or email.
                        </small>

                    </div>


                    {{-- Appointment --}}
                    <div class="col-md-6">

                        <label
                            for="bill_appointment_id"
                            class="form-label fw-bold"
                        >
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

                        <label
                            for="billing_date"
                            class="form-label fw-bold"
                        >
                            Billing Date
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="billing_date"
                            id="billing_date"
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

                        <label
                            for="discount_percentage"
                            class="form-label fw-bold"
                        >
                            Discount
                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="discount_percentage"
                                id="discount_percentage"
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


            {{-- Modal Footer --}}
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
                    <i class="fa-solid fa-file-invoice me-1"></i>
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


    /*
     * Searchable Patient Dropdown
     */
    const patientDropdown = new TomSelect(patientSelect, {

        placeholder: 'Search or select patient...',

        allowEmptyOption: true,

        maxOptions: 100,

        searchField: ['text'],

    });


    /*
     * Reset Appointment Dropdown
     */
    function resetAppointments(message) {

        appointmentSelect.innerHTML = '';

        const option =
            document.createElement('option');

        option.value = '';

        option.textContent = message;

        appointmentSelect.appendChild(option);

        appointmentSelect.disabled = true;
    }


    /*
     * Load Patient Appointments
     */
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


                /*
                 * Default Option
                 */
                const defaultOption =
                    document.createElement('option');

                defaultOption.value = '';

                defaultOption.textContent =
                    'No Appointment';

                appointmentSelect.appendChild(
                    defaultOption
                );


                /*
                 * Appointment Options
                 */
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


                /*
                 * No Appointments
                 */
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


    /*
     * Patient Changed
     */
    patientSelect.addEventListener(
        'change',
        function () {

            loadAppointments(this.value);

        }
    );


    /*
     * Load Existing Patient
     *
     * Useful when validation fails and
     * old('patient_id') is available.
     */
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
