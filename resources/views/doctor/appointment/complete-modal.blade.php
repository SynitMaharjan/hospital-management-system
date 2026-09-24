<!-- Complete Appointment Confirmation Modal -->

<div
    class="modal fade"
    id="completeAppointmentModal"
    tabindex="-1"
    aria-labelledby="completeAppointmentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <!-- Body -->
            <div class="modal-body text-center px-4 pb-4">

                <!-- Icon -->
                <div
                    class="mx-auto mb-3 rounded-circle bg-success-subtle
                           d-flex align-items-center justify-content-center"
                    style="width: 64px; height: 64px;"
                >
                    <i class="fa-solid fa-check text-success fs-3"></i>
                </div>


                <!-- Title -->
                <h5
                    class="fw-semibold mb-2"
                    id="completeAppointmentModalLabel"
                >
                    Complete Appointment?
                </h5>


                <!-- Message -->
                <p class="text-muted mb-4">
                    Are you sure you want to mark this appointment as completed?
                </p>


                <!-- Actions -->
                <div class="d-flex justify-content-center gap-2">

                    <button
                        type="button"
                        class="btn btn-light border px-4"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <button
                        type="button"
                        class="btn btn-success px-4"
                        id="confirmCompleteAppointment"
                    >
                        <i class="fa-solid fa-check me-1"></i>
                        Mark as Complete
                    </button>

                </div>

            </div>

        </div>

    </div>
</div>
