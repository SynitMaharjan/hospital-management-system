<h2>Receptionist Appointments</h2>

@if (session("success"))
    <p>{{ session("success") }}</p>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route("receptionist.appointment.store") }}">
    @csrf

    <div>
        <label>Patient</label>

        <select name="patient_id" required>
            <option value="">Select Patient</option>

            @foreach ($patients as $patient)
                <option value="{{ $patient->id }}">
                    {{ $patient->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Doctor</label>

        <select name="doctor_id" required>
            <option value="">Select Doctor</option>

            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">
                    Dr. {{ $doctor->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Date</label>
        <input type="date" name="appointment_date" required>
    </div>

    <div>
        <label>Time</label>
        <input type="time" name="appointment_time" required>
    </div>

    <div>
        <label>Reason</label>
        <textarea name="reason" required></textarea>
    </div>

    <button type="submit">Create Appointment</button>
</form>

<hr>

<h3>Existing Appointments</h3>

@foreach ($appointments as $appointment)
    <p>
        Patient: {{ $appointment->patient->user->name }}
        |
        Doctor: Dr. {{ $appointment->doctor->user->name }}
        |
        Date: {{ $appointment->appointment_date }}
        |
        Time: {{ $appointment->appointment_time }}
        |
        Status: {{ $appointment->status }}
    </p>
@endforeach

{{ $appointments->links() }}