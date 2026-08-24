@extends("layouts.app")

@section("content")

<div class="container py-4">

    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Total Staff</h5>
                    <h2>{{ $totalStaff }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Doctors</h5>
                    <h2>{{ $totalDoctors }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Nurses</h5>
                    <h2>{{ $totalNurses }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Receptionists</h5>
                    <h2>{{ $totalReceptionists }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Patients</h5>
                    <h2>{{ $totalPatients }}</h2>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="mt-5">

    <h3>Staff Management</h3>

    <p class="text-muted">
        Manage doctors, nurses, and other hospital staff.
    </p>

    <div class="d-flex gap-2">

        <a href="{{ route('admin.staff.index') }}"
           class="btn btn-primary">
            View All Staff
        </a>

        <a href="{{ route('admin.staff.create') }}"
           class="btn btn-success">
            Create Staff Account
        </a>

    </div>

</div>

@endsection