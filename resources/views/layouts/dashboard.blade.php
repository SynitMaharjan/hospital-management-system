@extends("layouts.app")

@section("content")

<div class="d-flex">

    <!-- Sidebar -->
    <aside class="bg-white border-end p-3" style="width: 240px; min-height: calc(100vh - 68px);">

        <div class="mb-4">
            <small class="text-muted text-uppercase fw-semibold">
                {{ ucfirst(auth()->user()->role) }}
            </small>

            <h5 class="fw-semibold mb-0">
                Dashboard
            </h5>
        </div>

        <nav>
            <ul class="nav nav-pills flex-column gap-1">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                       class="nav-link {{ request()->routeIs(auth()->user()->role . '.dashboard') ? 'active' : 'text-dark' }}">
                        Dashboard
                    </a>
                </li>

                @if(auth()->user()->role === "admin")
                    <li class="nav-item">
                        <a href="{{ route("admin.staff.index") }}"
                           class="nav-link {{ request()->routeIs("admin.staff.*") ? 'active' : 'text-dark' }}">
                            Staff
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.patient.index") }}"
                           class="nav-link {{ request()->routeIs("admin.patient.*") ? 'active' : 'text-dark' }}">
                            Patients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Appointments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Departments
                        </a>
                    </li>

                @elseif(auth()->user()->role === "doctor")

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Appointments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            My Patients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Medical Records
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Prescriptions
                        </a>
                    </li>

                @elseif(auth()->user()->role === "nurse")

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Assigned Patients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Appointments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Patient Records
                        </a>
                    </li>

                @elseif(auth()->user()->role === "reception")

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Patients
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Appointments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Check-in
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Billing
                        </a>
                    </li>

                @elseif(auth()->user()->role === "patient")

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Book Appointment
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            My Appointments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Medical Records
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark">
                            Prescriptions
                        </a>
                    </li>

                @endif

            </ul>
        </nav>

    </aside>

    <!-- Dashboard Area -->
    <div class="flex-grow-1">

        <!-- Dashboard Header -->
        <header class="bg-white border-bottom px-4 py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1 fw-semibold">
                        @yield("page-title")
                    </h4>

                    <small class="text-muted">
                        Hospital Management System
                    </small>
                </div>

                <div class="text-end">

                    <div class="fw-medium">
                        {{ auth()->user()->name }}
                    </div>

                    <small class="text-muted">
                        {{ ucfirst(auth()->user()->role) }}
                    </small>

                </div>

            </div>

        </header>


        <!-- Page Content -->
        <main class="p-4">

            @yield("dashboard-content")

        </main>

    </div>

</div>

@endsection