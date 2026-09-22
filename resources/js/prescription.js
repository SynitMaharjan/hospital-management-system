document.addEventListener('DOMContentLoaded', () => {

    const prescriptionForm = document.getElementById('prescription-form');

    if (!prescriptionForm) {
        return;
    }

    let medicineIndex = 0;

    const template = document.getElementById('medicine-template');
    const container = document.getElementById('medicines-container');
    const addBtn = document.getElementById('add-medicine-btn');
    const medicalRecordSelect = document.getElementById('medical_record_id');

    addMedicineRow();

    addBtn.addEventListener('click', addMedicineRow);

    function addMedicineRow() {
        const clone = template.content.cloneNode(true);
        const row = clone.querySelector('.medicine-row');

        row.dataset.index = medicineIndex;

        row.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(
                /__INDEX__/g,
                medicineIndex
            );
        });

        container.appendChild(clone);

        medicineIndex++;

        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const rows = container.querySelectorAll('.medicine-row');

        rows.forEach(row => {
            const button = row.querySelector('.remove-medicine-btn');

            button.disabled = rows.length <= 1;
        });
    }

    container.addEventListener('click', event => {
        const button = event.target.closest('.remove-medicine-btn');

        if (!button) {
            return;
        }

        const row = button.closest('.medicine-row');
        const rows = container.querySelectorAll('.medicine-row');

        if (rows.length > 1) {
            row.remove();
            updateRemoveButtons();
        }
    });

    medicalRecordSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        document.getElementById('patient_name_display').value =
            selectedOption.dataset.patientName || '';

        document.getElementById('patient_number_display').value =
            selectedOption.dataset.patientNumber || '';

        document.getElementById('patient_phone_display').value =
            selectedOption.dataset.phone || '';
    });

    if (medicalRecordSelect.value) {
        medicalRecordSelect.dispatchEvent(
            new Event('change')
        );
    }
});