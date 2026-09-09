@php
    use App\Enums\Role;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hospital Management System</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

        <div class="container-fluid px-4">

            @auth

                <!-- Brand -->
                <a
                    class="navbar-brand fw-bold"
                    href="{{ route(auth()->user()->role->value . '.dashboard') }}"
                >
                    Hospital Management System
                </a>


                <!-- User Profile -->
                <div class="dropdown">

                    <button
                        class="btn btn-link text-white text-decoration-none p-0 d-flex align-items-center gap-2"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >

                        <!-- Profile Picture -->
                        <img
                            src="{{ auth()->user()->profile_picture_url }}"
                            alt="Profile Picture"
                            class="rounded-circle border border-2 border-white"
                            style="
                                width: 40px;
                                height: 40px;
                                object-fit: cover;
                            "
                        >

                        <!-- Name + Role -->
                        <div class="text-start d-none d-sm-block">

                            <div class="fw-semibold lh-1">
                                {{ auth()->user()->name }}
                            </div>

                            <small class="text-white-50">
                                {{ ucfirst(auth()->user()->role->value) }}
                            </small>

                        </div>

                        <!-- Dropdown Arrow -->
                        <i class="fas fa-chevron-down small ms-1"></i>

                    </button>


                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2">

                        <!-- User Info -->
                        <li>
                            <div class="dropdown-header">

                                <div class="fw-semibold">
                                    {{ auth()->user()->name }}
                                </div>

                                <small class="text-muted">
                                    {{ ucfirst(auth()->user()->role->value) }}
                                </small>

                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <!-- Profile -->
                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('profile.show') }}"
                            >
                                <i class="fas fa-user me-2 text-muted"></i>
                                Profile
                            </a>
                        </li>


                        <!-- Settings -->
                        <li>
                            <a
                                class="dropdown-item"
                                href="#"
                            >
                                <i class="fas fa-cog me-2 text-muted"></i>
                                Settings
                            </a>
                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <!-- Logout -->
                        <li>

                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item text-danger"
                                >
                                    <i class="fas fa-right-from-bracket me-2"></i>
                                    Logout
                                </button>

                            </form>

                        </li>

                    </ul>

                </div>

            @else

                <a
                    class="navbar-brand fw-bold"
                    href="{{ url('/') }}"
                >
                    Hospital Management System
                </a>

            @endauth

        </div>

    </nav>


    <!-- Main Content -->

    <main>

        @yield('content')

    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>