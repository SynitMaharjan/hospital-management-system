document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('profilePicInput');
    const preview = document.getElementById('profilePreview');
    const form = document.getElementById('profilePictureForm');
    const changePhotoButton = document.getElementById('changePhotoButton');

    if (!input || !preview || !form || !changePhotoButton) {
        return;
    }

    changePhotoButton.addEventListener('click', () => {
        input.click();
    });

    input.addEventListener('change', () => {
        const file = input.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = (event) => {
            preview.src = event.target.result;
        };

        reader.readAsDataURL(file);

        form.submit();
    });
});