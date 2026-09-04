<h2>My Appointments</h2>

@forelse($appointments as $appointment)

    <div>
        <p>
            Doctor:
            {{ $appointment->doctor->user->name }}
        </p>

        <p>
            Department:
            {{ $appointment->doctor->department->name }}
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
    </div>

    <hr>

@empty

    <p>No appointments found.</p>

@endforelse

{{ $appointments->links() }}