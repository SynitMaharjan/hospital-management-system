@extends('layouts.dashboard')

@section('page-title', 'Book Appointment')

@section('dashboard-content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Book Appointment</h4>


<a href="{{ route('patient.appointment.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-1"></i>
    Back to Appointments
</a>


</div>

<div class="card">
    <div class="card-body">


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patient.appointment.store') }}" method="POST">
        @csrf

        <!-- Department & Doctor -->
        <div class="row mb-3">

            <div class="col-md-6">
                <label for="department_id" class="form-label">
                    Department
                </label>

                <select
                    name="department_id"
                    id="department_id"
                    class="form-select"
                    required
                >
                    <option value="">Select Department</option>

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

            <div class="col-md-6">
                <label for="doctor_id" class="form-label">
                    Doctor
                </label>

                <select
                    name="doctor_id"
                    id="doctor_id"
                    class="form-select"
                    required
                >
                    <option value="">Select Doctor</option>
                </select>
            </div>

        </div>

        <!-- Date & Time -->
        <div class="row mb-3">

            <div class="col-md-6">
                <label for="appointment_date" class="form-label">
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

            <div class="col-md-6">
                <label for="appointment_time" class="form-label">
                    Appointment Time
                </label>

                <select
                    name="appointment_time"
                    id="appointment_time"
                    class="form-select"
                    required
                >
                    <option value="">Select Time</option>

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
            </div>

        </div>

        <!-- Reason -->
        <div class="mb-3">

            <label for="reason" class="form-label">
                Reason for Appointment
            </label>

            <textarea
                name="reason"
                id="reason"
                class="form-control"
                rows="3"
                maxlength="255"
                required
            >{{ old('reason') }}</textarea>

        </div>

        <!-- Submit -->
        <div class="d-grid">

            <button type="submit" class="btn btn-primary">
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

        console.log('Doctors:', doctors);
        console.log('Selected department:', departmentSelect.value);

        departmentSelect.addEventListener('change', function () {

            console.log('Department changed:', this.value);

            doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

            doctors.forEach(function (doctor) {

                console.log(
                    'Doctor department:',
                    doctor.department_id,
                    'Selected department:',
                    this.value
                );

                if (doctor.department_id == this.value) {

                    const option = document.createElement('option');

                    option.value = doctor.id;

                    option.textContent =
                        doctor.user.name +
                        ' (' +
                        doctor.specialization +
                        ')';

                    doctorSelect.appendChild(option);
                }

            }, this);
        });

    });
</script>
@endpush

@endsection
