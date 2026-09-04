<h2>My Appointments</h2>

@if(session("success"))
    <div>
        {{ session("success") }}
    </div>
@endif

@forelse($appointments as $appointment)

    <div>
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
            {{ $appointment->status }}
        </p>
    </div>

    <hr>

@empty

    <p>No appointments found.</p>

@endforelse

{{ $appointments->links() }}