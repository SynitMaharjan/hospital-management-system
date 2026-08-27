@extends("layouts.app")

@section("content")

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>Staff Details</h1>
            <p class="text-muted mb-0">
                View staff account information.
            </p>
        </div>

        <a href="{{ route("admin.staff.index") }}"
           class="btn btn-secondary">
            Back to Staff
        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="mb-4">
                {{ $staff->name }}
            </h4>

            <div class="row mb-3">

                <div class="col-md-4 fw-bold">
                    Name
                </div>

                <div class="col-md-8">
                    {{ $staff->name }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4 fw-bold">
                    Username
                </div>

                <div class="col-md-8">
                    {{ $staff->username }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4 fw-bold">
                    Employee ID
                </div>

                <div class="col-md-8">
                    {{ $staff->employee_id }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4 fw-bold">
                    Email
                </div>

                <div class="col-md-8">
                    {{ $staff->email }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4 fw-bold">
                    Role
                </div>

                <div class="col-md-8">
                    {{ ucfirst($staff->role) }}
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4 fw-bold">
                    Account Created
                </div>

                <div class="col-md-8">
                    {{ $staff->created_at->format("M d, Y") }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection