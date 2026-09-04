<h2>Appointment Details</h2>

<p>
    Patient:
    {{ $appointment->patient->user->name }}
</p>

<p>
    Date:
    {{ $appointment->appointment_date }}
</p>

<p>
    Time:
    {{ $appointment->appointment_time }}
</p>

<p>
    Reason:
    {{ $appointment->reason }}
</p>

<p>
    Status:
    {{ $appointment->status->value }}
</p>

@if($appointment->status->value === "pending")

    <form
        action="{{ route("doctor.appointment.update", $appointment->id) }}"
        method="POST"
    >
        @csrf
        @method("PUT")

        <input type="hidden" name="status" value="confirmed">

        <button type="submit">
            Approve
        </button>
    </form>

    <form
        action="{{ route("doctor.appointment.update", $appointment->id) }}"
        method="POST"
    >
        @csrf
        @method("PUT")

        <input type="hidden" name="status" value="cancelled">

        <button type="submit">
            Reject
        </button>
    </form>

@endif

<a href="{{ route("doctor.appointment.index") }}">
    Back to Appointments
</a>