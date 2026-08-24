@extends("layouts.app")

@section("content")

<div class="container py-4">

    <div class="mb-4">
        <h1>Edit Staff</h1>
        <p class="text-muted">
            Update staff account information.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route("admin.staff.update", $staff) }}"
                  method="POST">

                @csrf
                @method("PUT")

                <div class="mb-3">

                    <label for="name" class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old("name", $staff->name) }}"
                    >

                    @error("name")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old("email", $staff->email) }}"
                    >

                    @error("email")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label for="role" class="form-label">
                        Role
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="form-select"
                    >

                        <option value="doctor"
                            {{ old("role", $staff->role) === "doctor" ? "selected" : "" }}>
                            Doctor
                        </option>

                        <option value="nurse"
                            {{ old("role", $staff->role) === "nurse" ? "selected" : "" }}>
                            Nurse
                        </option>

                        <option value="receptionist"
                            {{ old("role", $staff->role) === "receptionist" ? "selected" : "" }}>
                            Receptionist
                        </option>

                    </select>

                    @error("role")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Update Staff
                    </button>

                    <a href="{{ route("admin.staff.index") }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection