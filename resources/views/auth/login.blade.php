@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-6 col-lg-5">

        <div class="card">

            <div class="card-body p-5">

                <h2 class="text-center fw-bold mb-2">
                    Welcome Back
                </h2>

                <p class="text-center text-muted mb-4">
                    Login to access the Hospital Management System.
                </p>


                <form method="POST" action="{{ route('login') }}">

                    @csrf


                    <div class="mb-3">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                        >

                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <div class="mb-4">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                        >

                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <button class="btn btn-primary w-100">
                        Login
                    </button>


                </form>


                <div class="text-center mt-4">

                    <small class="text-muted">

                        Don't have an account?

                        <a href="{{ route('register') }}">
                            Register
                        </a>

                    </small>

                </div>


            </div>

        </div>

    </div>

</div>

@endsection