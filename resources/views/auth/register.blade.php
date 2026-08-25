@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-6 col-lg-5">

        <div class="card">

            <div class="card-body p-5">

                <h2 class="text-center fw-bold mb-2">
                    Create Account
                </h2>

                <p class="text-center text-muted mb-4">
                    Register to access the Hospital Management System.
                </p>

                <form method="POST" action="{{ route('register') }}">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter your full name"
                            value="{{ old('name') }}"
                        >

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Enter your username"
                            value="{{ old('username') }}"
                        >

                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                        >

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Create a password"
                        >
                        <small class="text-muted">
                          Password must contain at least 8 characters, including:
                          one uppercase letter, one lowercase letter, one number,
                          and one special character (@$!%*?&).
                        </small>

                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                      
                    <label for="password_confirmation" class="form-label">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                    >

                    @error("password_confirmation")
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    <button class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <div class="text-center mt-4">

                    <small class="text-muted">
                        Already have an account?
                        <a href="{{ route('login') }}">Login</a>
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection