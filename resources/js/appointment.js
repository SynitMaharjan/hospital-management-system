document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.complete-appointment-btn').forEach(button => {

        button.addEventListener('click', async () => {

            const appointmentId = button.dataset.appointmentId;

            if (!confirm('Mark this appointment as completed?')) {
                return;
            }

            try {
                const response = await fetch(
                    `/doctor/appointment/${appointmentId}`,
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
                    throw new Error();
                }

                window.location.reload();

            } catch {
                alert('Failed to complete appointment.');
            }
        });

    });

});