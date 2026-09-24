@extends("layouts.app")

@php
use App\Enums\Role;
@endphp

@section("content")

<div class="d-flex min-vh-100">


<!-- Sidebar -->
<aside
    class="bg-white border-end flex-shrink-0"
    style="width: 240px;"
>

    <div class="p-3">

        <!-- Sidebar Header -->
        <div class="mb-4">

            <small class="text-muted text-uppercase fw-semibold">
                {{ ucfirst(auth()->user()->role->value) }}
            </small>

            <h5 class="fw-semibold mb-0">
                Dashboard
            </h5>

        </div>


        <!-- Navigation -->
        <nav>

            <ul class="nav nav-pills flex-column gap-1">

                <!-- Dashboard -->
                <li class="nav-item">

                    <a
                        href="{{ route(auth()->user()->role->value . '.dashboard') }}"
                        class="nav-link {{ request()->routeIs(auth()->user()->role->value . '.dashboard') ? 'active' : 'text-dark' }}"
                    >
                        Dashboard
                    </a>

                </li>


                {{-- ================= ADMIN ================= --}}
                @if(auth()->user()->role === Role::ADMIN)

                    <li class="nav-item">

                        <a
                            href="{{ route('admin.staff.index') }}"
                            class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : 'text-dark' }}"
                        >
                            Staff
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('admin.patient.index') }}"
                            class="nav-link {{ request()->routeIs('admin.patient.*') ? 'active' : 'text-dark' }}"
                        >
                            Patients
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('admin.appointment.index') }}"
                            class="nav-link {{ request()->routeIs('admin.appointment.*') ? 'active' : 'text-dark' }}"
                        >
                            Appointments
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('admin.department.index') }}"
                            class="nav-link {{ request()->routeIs('admin.department.*') ? 'active' : 'text-dark' }}"
                        >
                            Departments
                        </a>

                    </li>


                {{-- ================= DOCTOR ================= --}}
                @elseif(auth()->user()->role === Role::DOCTOR)

                    <li class="nav-item">

                        <a
                            href="{{ route('doctor.appointment.index') }}"
                            class="nav-link {{ request()->routeIs('doctor.appointment.*') ? 'active' : 'text-dark' }}"
                        >
                            Appointments
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('doctor.patient.index') }}"
                            class="nav-link {{ request()->routeIs('doctor.patient.*') ? 'active' : 'text-dark' }}"
                        >
                            My Patients
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('doctor.medical-record.index') }}"
                            class="nav-link {{ request()->routeIs('doctor.medical-record.*') ? 'active' : 'text-dark' }}"
                        >
                            Medical Records
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('doctor.prescription.index') }}"
                            class="nav-link {{ request()->routeIs('doctor.prescription.*') ? 'active' : 'text-dark' }}"
                        >
                            Prescriptions
                        </a>

                    </li>


                {{-- ================= NURSE ================= --}}
                @elseif(auth()->user()->role === Role::NURSE)

                    <li class="nav-item">

                        <a
                            href="#"
                            class="nav-link text-dark"
                        >
                            Assigned Patients
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="#"
                            class="nav-link text-dark"
                        >
                            Appointments
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="#"
                            class="nav-link text-dark"
                        >
                            Patient Records
                        </a>

                    </li>


                {{-- ================= RECEPTIONIST ================= --}}
                @elseif(auth()->user()->role === Role::RECEPTIONIST)

                    <li class="nav-item">

                        <a
                            href="{{ route('receptionist.patient.index') }}"
                            class="nav-link {{ request()->routeIs('receptionist.patient.*') ? 'active' : 'text-dark' }}"
                        >
                            Patients
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('receptionist.appointment.index') }}"
                            class="nav-link {{ request()->routeIs('receptionist.appointment.*') ? 'active' : 'text-dark' }}"
                        >
                            Appointments
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('receptionist.check-in.index') }}"
                            class="nav-link {{ request()->routeIs('receptionist.check-in.*') ? 'active' : 'text-dark' }}"
                        >
                            Check-in
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('receptionist.bill.index') }}"
                            class="nav-link {{ request()->routeIs('receptionist.bill.*') ? 'active' : 'text-dark' }}"
                        >
                            Billing
                        </a>

                    </li>


                {{-- ================= PATIENT ================= --}}
                @elseif(auth()->user()->role === Role::PATIENT)

                    <li class="nav-item">

                        <a
                            href="{{ route('patient.appointment.index') }}"
                            class="nav-link {{ request()->routeIs('patient.appointment.index') ? 'active' : 'text-dark' }}"
                        >
                            My Appointments
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('patient.appointment.create') }}"
                            class="nav-link {{ request()->routeIs('patient.appointment.create') ? 'active' : 'text-dark' }}"
                        >
                            Book Appointment
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('patient.medical-record.index') }}"
                            class="nav-link {{ request()->routeIs('patient.medical-record.index') ? 'active' : 'text-dark' }}"
                        >
                            Medical Records
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            href="{{ route('patient.prescription.index') }}"
                            class="nav-link {{ request()->routeIs('patient.prescription.index') ? 'active' : 'text-dark' }}"
                        >
                            Prescriptions
                        </a>

                    </li>

                @endif

            </ul>

        </nav>

    </div>

</aside>


<!-- Main Dashboard Area -->
<div
    class="flex-grow-1"
    style="min-width: 0;"
>

    <!-- Page Content -->
    <main
        class="p-4"
        style="min-width: 0;"
    >

        @yield("dashboard-content")

    </main>

</div>


</div>

@stack('scripts')

@endsection