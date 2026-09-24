<!-- Show Appointment Modal -->

<div
    class="modal fade"
    id="showAppointmentModal{{ $appointment->id }}"
    tabindex="-1"
    aria-labelledby="showAppointmentModalLabel{{ $appointment->id }}"
    aria-hidden="true"
>


<div class="modal-dialog modal-lg modal-dialog-centered">

    <div class="modal-content">


        <!-- Modal Header -->

        <div class="modal-header">

            <h5
                class="modal-title"
                id="showAppointmentModalLabel{{ $appointment->id }}"
            >

                <i class="fas fa-calendar-check me-2"></i>

                Appointment Details

            </h5>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>

        </div>


        <!-- Modal Body -->

        <div class="modal-body">


            <!-- Appointment Information -->

            <h6 class="fw-bold mb-3">
                Appointment Information
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Appointment Number
                    </small>

                    <span class="fw-medium">
                        {{ $appointment->appointment_number }}
                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Status
                    </small>

                    <span class="badge bg-{{
                        match($appointment->status->value) {
                            'pending' => 'warning',
                            'confirmed' => 'success',
                            'cancelled' => 'danger',
                            'completed' => 'info',
                            default => 'secondary'
                        }
                    }}">

                        {{ ucfirst($appointment->status->value) }}

                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Date
                    </small>

                    <span>
                        {{ $appointment->appointment_date->format('M d, Y') }}
                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Time
                    </small>

                    <span>
                        {{ $appointment->appointment_time->format('h:i A') }}
                    </span>

                </div>

            </div>


            <!-- Patient Information -->

            <h6 class="fw-bold mb-3">
                Patient Information
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Name
                    </small>

                    <span class="fw-medium">
                        {{ $appointment->patient->full_name }}
                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Email
                    </small>

                    <span>
                        {{ $appointment->patient->email ?? 'No email provided' }}
                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Phone
                    </small>

                    <span>
                        {{ $appointment->patient->phone ?? 'No phone provided' }}
                    </span>

                </div>

            </div>


            <!-- Doctor Information -->

            <h6 class="fw-bold mb-3">
                Doctor Information
            </h6>

            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Doctor
                    </small>

                    <span class="fw-medium">
                        Dr. {{ $appointment->doctor->user->name }}
                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Specialization
                    </small>

                    <span>
                        {{ $appointment->doctor->specialization }}
                    </span>

                </div>


                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Department
                    </small>

                    <span>
                        {{ $appointment->doctor->department->name ?? 'No department assigned' }}
                    </span>

                </div>

            </div>


            <!-- Reason -->

            <h6 class="fw-bold mb-2">
                Reason for Appointment
            </h6>

            <div class="bg-light rounded p-3">

                {{ $appointment->reason }}

            </div>

        </div>


        <!-- Modal Footer -->

        <div class="modal-footer">

            <button
                type="button"
                class="btn btn-outline-secondary"
                data-bs-dismiss="modal"
            >

                Close

            </button>


            @if ($appointment->status->value === 'pending')


                <!-- Confirm -->

                <form
                    action="{{ route('receptionist.appointment.update', $appointment->id) }}"
                    method="POST"
                >

                    @csrf

                    @method('PUT')

                    <input
                        type="hidden"
                        name="status"
                        value="confirmed"
                    >

                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        <i class="fas fa-check me-1"></i>

                        Confirm Appointment

                    </button>

                </form>


                <!-- Cancel -->

                <form
                    action="{{ route('receptionist.appointment.update', $appointment->id) }}"
                    method="POST"
                >

                    @csrf

                    @method('PUT')

                    <input
                        type="hidden"
                        name="status"
                        value="cancelled"
                    >

                    <button
                        type="submit"
                        class="btn btn-outline-danger"
                    >

                        <i class="fas fa-times me-1"></i>

                        Cancel Appointment

                    </button>

                </form>

            @endif

        </div>

    </div>

</div>


</div>
