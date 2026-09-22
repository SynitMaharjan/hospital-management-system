@extends('layouts.dashboard')

@section('page-title')
    Create Medical Record
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-1">

                <div class="text-primary fs-4">
                    <i class="fa-solid fa-file-medical"></i>
                </div>

                <h2 class="fw-semibold mb-0">
                    Create Medical Record
                </h2>

            </div>

            <p class="text-muted mb-0">
                Document a patient consultation
            </p>
        </div>


        <a
            href="{{ route('doctor.medical-record.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Records
        </a>

    </div>


    @if($appointments->isEmpty())

        <!-- No Appointments -->
        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <div
                    class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width: 64px; height: 64px;"
                >
                    <i class="fa-solid fa-calendar-xmark fs-4"></i>
                </div>

                <h5 class="fw-semibold mb-2">
                    No Appointments Available
                </h5>

                <p class="text-muted mb-4">
                    There are currently no appointments available for creating a medical record.
                    All your appointments may already have medical records.
                </p>

                <a
                    href="{{ route('doctor.medical-record.index') }}"
                    class="btn btn-outline-primary"
                >
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Back to Medical Records
                </a>

            </div>

        </div>

    @else

        <form
            method="POST"
            action="{{ route('doctor.medical-record.store') }}"
        >

            @csrf

            <div class="row g-4">

                <!-- Appointment Selection -->
                <div class="col-12">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="text-primary">
                                    <i class="fa-solid fa-calendar-check fs-5"></i>
                                </div>

                                <div>

                                    <h5 class="fw-semibold mb-1">
                                        Select Appointment
                                    </h5>

                                    <small class="text-muted">
                                        Select the appointment for this consultation
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body px-4 pb-4">

                            <label
                                for="appointment_id"
                                class="form-label fw-medium"
                            >
                                Appointment
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="appointment_id"
                                id="appointment_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select an appointment...
                                </option>

                                @foreach($appointments as $appointment)

                                    <option
                                        value="{{ $appointment->id }}"
                                        data-patient-name="{{ $appointment->patient->full_name }}"
                                        data-patient-number="{{ $appointment->patient->patient_number }}"
                                        data-patient-phone="{{ $appointment->patient->phone }}"
                                        data-appointment-date="{{ $appointment->appointment_date->format('Y-m-d') }}"
                                        data-appointment-date-display="{{ $appointment->appointment_date->format('M d, Y') }}"
                                        data-appointment-time="{{ $appointment->appointment_time->format('g:i A') }}"
                                        @selected(old('appointment_id') == $appointment->id)
                                    >

                                        {{ $appointment->patient->full_name }}
                                        ({{ $appointment->patient->patient_number }})
                                        —
                                        {{ $appointment->appointment_date->format('M d, Y') }}
                                        at
                                        {{ $appointment->appointment_time->format('g:i A') }}

                                    </option>

                                @endforeach

                            </select>

                            <div class="form-text mt-2">

                                <i class="fa-solid fa-circle-info me-1"></i>

                                The patient is automatically determined from the selected appointment.

                            </div>

                            @error('appointment_id')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                <!-- Patient Information -->
                <div class="col-12">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="text-primary">
                                    <i class="fa-solid fa-user fs-5"></i>
                                </div>

                                <div>

                                    <h5 class="fw-semibold mb-1">
                                        Patient Information
                                    </h5>

                                    <small class="text-muted">
                                        Automatically loaded from the selected appointment
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body px-4 pb-4">

                            <div class="row g-3">

                                <!-- Patient Name -->
                                <div class="col-lg-3 col-md-6">

                                    <label
                                        for="patient_name_display"
                                        class="form-label fw-medium"
                                    >
                                        Patient Name
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-user text-muted"></i>
                                        </span>

                                        <input
                                            type="text"
                                            class="form-control bg-light"
                                            readonly
                                            id="patient_name_display"
                                        >

                                    </div>

                                </div>


                                <!-- Patient Number -->
                                <div class="col-lg-3 col-md-6">

                                    <label
                                        for="patient_number_display"
                                        class="form-label fw-medium"
                                    >
                                        Patient Number
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-id-card text-muted"></i>
                                        </span>

                                        <input
                                            type="text"
                                            class="form-control bg-light"
                                            readonly
                                            id="patient_number_display"
                                        >

                                    </div>

                                </div>


                                <!-- Phone -->
                                <div class="col-lg-3 col-md-6">

                                    <label
                                        for="patient_phone_display"
                                        class="form-label fw-medium"
                                    >
                                        Phone
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-phone text-muted"></i>
                                        </span>

                                        <input
                                            type="text"
                                            class="form-control bg-light"
                                            readonly
                                            id="patient_phone_display"
                                        >

                                    </div>

                                </div>


                                <!-- Appointment Date -->
                                <div class="col-lg-3 col-md-6">

                                    <label
                                        for="appointment_datetime_display"
                                        class="form-label fw-medium"
                                    >
                                        Appointment
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-calendar-days text-muted"></i>
                                        </span>

                                        <input
                                            type="text"
                                            class="form-control bg-light"
                                            readonly
                                            id="appointment_datetime_display"
                                        >

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Clinical Details -->
                <div class="col-12">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="text-primary">
                                    <i class="fa-solid fa-stethoscope fs-5"></i>
                                </div>

                                <div>

                                    <h5 class="fw-semibold mb-1">
                                        Clinical Details
                                    </h5>

                                    <small class="text-muted">
                                        Record the findings and treatment from this consultation
                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body px-4 pb-4">

                            <!-- Record Date -->
                            <div class="mb-4">

                                <label
                                    for="record_date"
                                    class="form-label fw-medium"
                                >
                                    Record Date
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="record_date"
                                    id="record_date"
                                    class="form-control"
                                    value="{{ old('record_date', now()->format('Y-m-d')) }}"
                                    required
                                >

                                @error('record_date')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <!-- Chief Complaint -->
                            <div class="mb-4">

                                <label
                                    for="chief_complaint"
                                    class="form-label fw-medium"
                                >
                                    Chief Complaint / Visit Reason
                                </label>

                                <textarea
                                    name="chief_complaint"
                                    id="chief_complaint"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Primary reason for the visit..."
                                >{{ old('chief_complaint') }}</textarea>

                                @error('chief_complaint')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <!-- Symptoms -->
                            <div class="mb-4">

                                <label
                                    for="symptoms"
                                    class="form-label fw-medium"
                                >
                                    Symptoms
                                </label>

                                <textarea
                                    name="symptoms"
                                    id="symptoms"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Patient's reported symptoms..."
                                >{{ old('symptoms') }}</textarea>

                                @error('symptoms')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <!-- Diagnosis -->
                            <div class="mb-4">

                                <label
                                    for="diagnosis"
                                    class="form-label fw-medium"
                                >
                                    Diagnosis
                                </label>

                                <textarea
                                    name="diagnosis"
                                    id="diagnosis"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Clinical diagnosis..."
                                >{{ old('diagnosis') }}</textarea>

                                @error('diagnosis')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <!-- Examination -->
                            <div class="mb-4">

                                <label
                                    for="examination"
                                    class="form-label fw-medium"
                                >
                                    Examination Findings
                                </label>

                                <textarea
                                    name="examination"
                                    id="examination"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Physical examination findings..."
                                >{{ old('examination') }}</textarea>

                                @error('examination')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <!-- Treatment -->
                            <div class="mb-4">

                                <label
                                    for="treatment"
                                    class="form-label fw-medium"
                                >
                                    Treatment Plan
                                </label>

                                <textarea
                                    name="treatment"
                                    id="treatment"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Prescribed treatment, procedures, referrals..."
                                >{{ old('treatment') }}</textarea>

                                @error('treatment')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <!-- Notes -->
                            <div>

                                <label
                                    for="notes"
                                    class="form-label fw-medium"
                                >
                                    Additional Notes
                                </label>

                                <textarea
                                    name="notes"
                                    id="notes"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Any additional clinical notes..."
                                >{{ old('notes') }}</textarea>

                                @error('notes')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Actions -->
                <div class="col-12">

                    <div class="d-flex flex-wrap gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Save Medical Record
                        </button>

                        <a
                            href="{{ route('doctor.medical-record.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            <i class="fa-solid fa-xmark me-1"></i>
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </form>

    @endif

</div>


<script>

    const appointmentSelect = document.getElementById('appointment_id');

    if (appointmentSelect) {

        function updatePatientInfo() {

            const selectedOption =
                appointmentSelect.options[appointmentSelect.selectedIndex];

            if (!selectedOption || !selectedOption.value) {

                document.getElementById('patient_name_display').value = '';
                document.getElementById('patient_number_display').value = '';
                document.getElementById('patient_phone_display').value = '';
                document.getElementById('appointment_datetime_display').value = '';

                return;
            }

            const patientName =
                selectedOption.dataset.patientName;

            const patientNumber =
                selectedOption.dataset.patientNumber;

            const patientPhone =
                selectedOption.dataset.patientPhone;

            const appointmentDate =
                selectedOption.dataset.appointmentDate;

            const appointmentDateDisplay =
                selectedOption.dataset.appointmentDateDisplay;

            const appointmentTime =
                selectedOption.dataset.appointmentTime;


            document.getElementById('patient_name_display').value =
                patientName || '';

            document.getElementById('patient_number_display').value =
                patientNumber || '';

            document.getElementById('patient_phone_display').value =
                patientPhone || '';

            document.getElementById('appointment_datetime_display').value =
                appointmentDateDisplay && appointmentTime
                    ? `${appointmentDateDisplay} at ${appointmentTime}`
                    : '';


            if (appointmentDate) {

                document.getElementById('record_date').value =
                    appointmentDate;

            }

        }


        appointmentSelect.addEventListener(
            'change',
            updatePatientInfo
        );


        updatePatientInfo();

    }

</script>

@endsection

