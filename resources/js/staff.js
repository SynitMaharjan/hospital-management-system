document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | Create Staff Modal
    |--------------------------------------------------------------------------
    */

    const createStaffModal =
        document.getElementById("createStaffModal");

    /*
    |--------------------------------------------------------------------------
    | Validation Errors
    |--------------------------------------------------------------------------
    */

    const staffPage =
        document.getElementById("staff-page");

    if (
        staffPage &&
        staffPage.dataset.validationErrors === "true" &&
        createStaffModal
    ) {

        const modal =
            new bootstrap.Modal(createStaffModal);

        modal.show();
    }


    /*
    |--------------------------------------------------------------------------
    | Staff Created Modal
    |--------------------------------------------------------------------------
    */

    const staffCreatedModal =
        document.getElementById("staffCreatedModal");

    if (staffCreatedModal) {

        const modal =
            new bootstrap.Modal(staffCreatedModal);

        modal.show();
    }


    /*
    |--------------------------------------------------------------------------
    | Copy Username / Password
    |--------------------------------------------------------------------------
    */

    const copyButtons =
        document.querySelectorAll(".copy-btn");

    copyButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const targetId =
                this.dataset.copyTarget;

            const target =
                document.getElementById(targetId);

            if (!target) {
                return;
            }

            navigator.clipboard
                .writeText(target.value)
                .then(() => {

                    const originalHTML =
                        this.innerHTML;

                    this.innerHTML =
                        '<i class="fa-solid fa-check me-1"></i> Copied';

                    this.classList.remove(
                        "btn-outline-secondary"
                    );

                    this.classList.add(
                        "btn-success"
                    );

                    setTimeout(() => {

                        this.innerHTML =
                            originalHTML;

                        this.classList.remove(
                            "btn-success"
                        );

                        this.classList.add(
                            "btn-outline-secondary"
                        );

                    }, 1500);

                })
                .catch(() => {

                    target.removeAttribute("readonly");

                    target.select();

                    document.execCommand("copy");

                    target.setAttribute(
                        "readonly",
                        true
                    );

                    const originalHTML =
                        this.innerHTML;

                    this.innerHTML =
                        '<i class="fa-solid fa-check me-1"></i> Copied';

                    this.classList.remove(
                        "btn-outline-secondary"
                    );

                    this.classList.add(
                        "btn-success"
                    );

                    setTimeout(() => {

                        this.innerHTML =
                            originalHTML;

                        this.classList.remove(
                            "btn-success"
                        );

                        this.classList.add(
                            "btn-outline-secondary"
                        );

                    }, 1500);

                });

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Show / Hide Temporary Password
    |--------------------------------------------------------------------------
    */

    const togglePassword =
        document.getElementById("togglePassword");

    const passwordInput =
        document.getElementById("createdPassword");

    if (
        togglePassword &&
        passwordInput
    ) {

        togglePassword.addEventListener(
            "click",
            function () {

                const isHidden =
                    passwordInput.type === "password";

                passwordInput.type =
                    isHidden
                        ? "text"
                        : "password";

                this.innerHTML =
                    isHidden
                        ? '<i class="fa-solid fa-eye-slash"></i>'
                        : '<i class="fa-solid fa-eye"></i>';

                this.title =
                    isHidden
                        ? "Hide password"
                        : "Show password";

            }
        );

    }

});