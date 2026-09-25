@extends('layouts.app')

@section('content')

<div class="container py-5">

<div class="row justify-content-center">

    <div class="col-12 col-sm-10 col-md-7 col-lg-5">

        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-4 p-md-5">

                {{-- Header --}}
                <div class="text-center mb-4">

                    <h2 class="fw-bold mb-2">
                        Welcome Back
                    </h2>

                    <p class="text-muted mb-0">
                        Login to access the Hospital Management System.
                    </p>

                </div>


                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    {{-- Username / Email --}}
                    <div class="mb-3">

                        <label
                            for="login"
                            class="form-label fw-semibold"
                        >
                            Username or Email Address
                        </label>

                        <input
                            type="text"
                            id="login"
                            name="login"
                            class="form-control"
                            placeholder="Enter your email or username"
                            value="{{ old('login') }}"
                            autofocus
                        >

                        @error('login')
                            <small class="text-danger d-block mt-1">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div class="mb-4">

                        <label
                            for="password"
                            class="form-label fw-semibold"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                        >

                        @error('password')
                            <small class="text-danger d-block mt-1">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- Login --}}
                    <button
                        type="submit"
                        class="btn btn-primary w-100 py-2 fw-semibold"
                    >
                        Login
                    </button>


                    {{-- Register --}}
                    <div class="text-center mt-4">

                        <span class="text-muted">
                            Don't have an account?
                        </span>

                        <a
                            href="{{ route('register') }}"
                            class="text-decoration-none fw-semibold"
                        >
                            Register
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</div>

@endsection
