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

    const staffCreated =
        document.getElementById("staff-created");

    if (
        staffCreated &&
        staffCreated.dataset.created === "true"
    ) {

        const createdModalElement =
            document.getElementById("staffCreatedModal");

        if (createdModalElement) {

            const createdModal =
                new bootstrap.Modal(createdModalElement);

            createdModal.show();
        }
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


    /*
    |--------------------------------------------------------------------------
    | Create Staff Role Fields
    |--------------------------------------------------------------------------
    */

    const roleSelect =
        document.getElementById("role");

    const departmentField =
        document.getElementById("departmentField");

    const doctorFields =
        document.getElementById("doctorFields");

    const departmentSelect =
        document.getElementById("department_id");

    const specializationInput =
        document.getElementById("specialization");

    const licenseInput =
        document.getElementById("license_number");


    if (
        roleSelect &&
        departmentField &&
        doctorFields &&
        departmentSelect &&
        specializationInput &&
        licenseInput
    ) {

        function updateStaffFields() {

            const role =
                roleSelect.value;


            /*
            |--------------------------------------------------------------------------
            | Hide Everything First
            |--------------------------------------------------------------------------
            */

            departmentField.style.display =
                "none";

            doctorFields.style.display =
                "none";


            /*
            |--------------------------------------------------------------------------
            | Disable Hidden Fields
            |--------------------------------------------------------------------------
            */

            departmentSelect.disabled =
                true;

            specializationInput.disabled =
                true;

            licenseInput.disabled =
                true;


            /*
            |--------------------------------------------------------------------------
            | Doctor
            |--------------------------------------------------------------------------
            */

            if (role === "doctor") {

                departmentField.style.display =
                    "block";

                doctorFields.style.display =
                    "block";


                departmentSelect.disabled =
                    false;

                specializationInput.disabled =
                    false;

                licenseInput.disabled =
                    false;

            }


            /*
            |--------------------------------------------------------------------------
            | Nurse
            |--------------------------------------------------------------------------
            */

            else if (role === "nurse") {

                departmentField.style.display =
                    "block";

                departmentSelect.disabled =
                    false;

            }


            /*
            |--------------------------------------------------------------------------
            | Receptionist
            |--------------------------------------------------------------------------
            */

            else if (role === "receptionist") {

                // Receptionist only needs common fields.
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Update When Role Changes
        |--------------------------------------------------------------------------
        */

        roleSelect.addEventListener(
            "change",
            updateStaffFields
        );


        /*
        |--------------------------------------------------------------------------
        | Set Initial State
        |--------------------------------------------------------------------------
        */

        updateStaffFields();

    }


    /*
    |--------------------------------------------------------------------------
    | Edit Staff Role Fields
    |--------------------------------------------------------------------------
    */

    const editRoleSelects =
        document.querySelectorAll(".edit-staff-role");


    editRoleSelects.forEach(function (roleSelect) {

        const staffId =
            roleSelect.dataset.staffId;

        if (!staffId) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Fields For This Staff Member
        |--------------------------------------------------------------------------
        */

        const departmentField =
            document.getElementById(
                `editDepartmentField${staffId}`
            );

        const doctorFields =
            document.getElementById(
                `editDoctorFields${staffId}`
            );

        const departmentSelect =
            document.getElementById(
                `department_id${staffId}`
            );

        const specializationInput =
            document.getElementById(
                `specialization${staffId}`
            );

        const licenseInput =
            document.getElementById(
                `license_number${staffId}`
            );


        /*
        |--------------------------------------------------------------------------
        | Make Sure Required Elements Exist
        |--------------------------------------------------------------------------
        */

        if (
            !departmentField ||
            !doctorFields ||
            !departmentSelect ||
            !specializationInput ||
            !licenseInput
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Edit Staff Fields
        |--------------------------------------------------------------------------
        */

        function updateEditStaffFields() {

            const role =
                roleSelect.value;


            /*
            |--------------------------------------------------------------------------
            | Hide Everything First
            |--------------------------------------------------------------------------
            */

            departmentField.style.display =
                "none";

            doctorFields.style.display =
                "none";


            /*
            |--------------------------------------------------------------------------
            | Disable Hidden Fields
            |--------------------------------------------------------------------------
            */

            departmentSelect.disabled =
                true;

            specializationInput.disabled =
                true;

            licenseInput.disabled =
                true;


            /*
            |--------------------------------------------------------------------------
            | Doctor
            |--------------------------------------------------------------------------
            */

            if (role === "doctor") {

                departmentField.style.display =
                    "block";

                doctorFields.style.display =
                    "block";


                departmentSelect.disabled =
                    false;

                specializationInput.disabled =
                    false;

                licenseInput.disabled =
                    false;

            }


            /*
            |--------------------------------------------------------------------------
            | Nurse
            |--------------------------------------------------------------------------
            */

            else if (role === "nurse") {

                departmentField.style.display =
                    "block";

                departmentSelect.disabled =
                    false;

            }


            /*
            |--------------------------------------------------------------------------
            | Receptionist
            |--------------------------------------------------------------------------
            */

            else if (role === "receptionist") {

                // No department-specific fields.
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Update When Role Changes
        |--------------------------------------------------------------------------
        */

        roleSelect.addEventListener(
            "change",
            updateEditStaffFields
        );


        /*
        |--------------------------------------------------------------------------
        | Set Initial State
        |--------------------------------------------------------------------------
        */

        updateEditStaffFields();

    });

});