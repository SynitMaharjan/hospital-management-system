<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hospital Management System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

        <div class="container">
            @auth
                <a class="navbar-brand fw-bold"
                   href="{{ route(auth()->user()->role . '.dashboard') }}">
                    Hospital Management System
                </a>

                <div class="ms-auto d-flex align-items-center">

                    <span class="text-white me-3">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Logout
                        </button>

                    </form>

                </div>
            @else
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    Hospital Management System
                </a>
            @endauth

        </div>

    </nav>

    <!-- Main Content -->
    <main>

        @yield('content')

    </main>

</body>
</html>