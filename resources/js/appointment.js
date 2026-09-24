document.addEventListener('DOMContentLoaded', () => {

    const modalElement = document.getElementById('completeAppointmentModal');
    const confirmButton = document.getElementById('confirmCompleteAppointment');

    if (!modalElement || !confirmButton) {
        return;
    }

    const completeModal = new bootstrap.Modal(modalElement);

    let selectedAppointmentId = null;


    // Open confirmation modal
    document.querySelectorAll('.complete-appointment-btn').forEach(button => {

        button.addEventListener('click', () => {

            selectedAppointmentId = button.dataset.appointmentId;

            completeModal.show();

        });

    });


    // Confirm appointment completion
    confirmButton.addEventListener('click', async () => {

        if (!selectedAppointmentId) {
            return;
        }


        // Disable button while request is processing
        confirmButton.disabled = true;

        confirmButton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                aria-hidden="true"
            ></span>
            Completing...
        `;


        try {

            const response = await fetch(
                `/doctor/appointment/${selectedAppointmentId}`,
                {
                    method: 'PATCH',

                    headers: {
                        'Content-Type': 'application/json',

                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),

                        'Accept': 'application/json',
                    },

                    body: JSON.stringify({
                        status: 'completed',
                    }),
                }
            );


            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }


            // Close modal
            completeModal.hide();


            // Refresh dashboard
            window.location.reload();


        } catch (error) {

            console.error(
                'Complete appointment error:',
                error
            );

            alert(
                `Failed to complete appointment: ${error.message}`
            );


            // Restore button
            confirmButton.disabled = false;

            confirmButton.innerHTML = `
                <i class="fa-solid fa-check me-1"></i>
                Mark as Complete
            `;

        }

    });

});