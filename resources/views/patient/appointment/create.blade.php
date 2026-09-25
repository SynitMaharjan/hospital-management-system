@extends('layouts.dashboard')

@section('page-title', 'Book Appointment')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
    <h4 class="fw-bold mb-1">Book Appointment</h4>
    <p class="text-muted mb-0">
        Schedule an appointment with one of our doctors.
    </p>
</div>

<a
    href="{{ route('patient.appointment.index') }}"
    class="btn btn-outline-secondary"
>
    <i class="fas fa-arrow-left me-1"></i>
    Back to Appointments
</a>

</div>

<div class="card border-0 shadow-sm">

<div class="card-body p-4 p-md-5">

    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <div class="fw-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="mb-0 ps-3">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('patient.appointment.store') }}"
        method="POST"
    >

        @csrf


        {{-- Doctor Selection --}}
        <h6 class="fw-bold mb-3">
            <i class="fas fa-user-doctor me-2 text-primary"></i>
            Doctor Information
        </h6>

        <div class="row g-3 mb-4">

            {{-- Department --}}
            <div class="col-md-6">

                <label
                    for="department_id"
                    class="form-label fw-semibold"
                >
                    Department
                </label>

                <select
                    name="department_id"
                    id="department_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Select Department
                    </option>

                    @foreach ($departments as $department)

                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id') == $department->id ? 'selected' : '' }}
                        >
                            {{ $department->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Doctor --}}
            <div class="col-md-6">

                <label
                    for="doctor_id"
                    class="form-label fw-semibold"
                >
                    Doctor
                </label>

                <select
                    name="doctor_id"
                    id="doctor_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Select Department First
                    </option>

                </select>

                <small class="text-muted">
                    Select a department to see available doctors.
                </small>

            </div>

        </div>


        {{-- Appointment Details --}}
        <h6 class="fw-bold mb-3">
            <i class="fas fa-calendar-check me-2 text-primary"></i>
            Appointment Details
        </h6>

        <div class="row g-3 mb-4">

            {{-- Date --}}
            <div class="col-md-6">

                <label
                    for="appointment_date"
                    class="form-label fw-semibold"
                >
                    Appointment Date
                </label>

                <input
                    type="date"
                    name="appointment_date"
                    id="appointment_date"
                    class="form-control"
                    value="{{ old('appointment_date') }}"
                    min="{{ today()->toDateString() }}"
                    required
                >

            </div>


            {{-- Time --}}
            <div class="col-md-6">

                <label
                    for="appointment_time"
                    class="form-label fw-semibold"
                >
                    Appointment Time
                </label>

                <select
                    name="appointment_time"
                    id="appointment_time"
                    class="form-select"
                    required
                >

                    <option value="">
                        Select Time
                    </option>

                    @for ($hour = 8; $hour <= 17; $hour++)

                        @for ($minute = 0; $minute < 60; $minute += 30)

                            @php
                                $time = sprintf('%02d:%02d', $hour, $minute);
                            @endphp

                            <option
                                value="{{ $time }}"
                                {{ old('appointment_time') === $time ? 'selected' : '' }}
                            >
                                {{ date('g:i A', strtotime($time)) }}
                            </option>

                        @endfor

                    @endfor

                </select>

                <small class="text-muted">
                    Available time slots are shown in 30-minute intervals.
                </small>

            </div>

        </div>


        {{-- Reason --}}
        <h6 class="fw-bold mb-3">
            <i class="fas fa-notes-medical me-2 text-primary"></i>
            Appointment Reason
        </h6>

        <div class="mb-4">

            <label
                for="reason"
                class="form-label fw-semibold"
            >
                Reason for Appointment
            </label>

            <textarea
                name="reason"
                id="reason"
                class="form-control"
                rows="4"
                maxlength="255"
                placeholder="Briefly describe the reason for your appointment..."
                required
            >{{ old('reason') }}</textarea>

            <small class="text-muted">
                Maximum 255 characters.
            </small>

        </div>


        {{-- Submit --}}
        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('patient.appointment.index') }}"
                class="btn btn-outline-secondary px-4"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary px-4"
            >
                <i class="fas fa-calendar-plus me-1"></i>
                Book Appointment
            </button>

        </div>

    </form>

</div>

</div>

@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const departmentSelect = document.getElementById('department_id');
        const doctorSelect = document.getElementById('doctor_id');

        const doctors = @json($doctors);


        departmentSelect.addEventListener('change', function () {

            const selectedDepartment = this.value;

            doctorSelect.innerHTML =
                '<option value="">Select Doctor</option>';


            doctors.forEach(function (doctor) {

                if (doctor.department_id == selectedDepartment) {

                    const option = document.createElement('option');

                    option.value = doctor.id;

                    option.textContent =
                        doctor.user.name +
                        ' (' +
                        doctor.specialization +
                        ')';

                    doctorSelect.appendChild(option);
                }

            });


            if (doctorSelect.options.length === 1) {

                doctorSelect.innerHTML =
                    '<option value="">No doctors available</option>';

            }

        });

    });

</script>

@endpush

@endsection
