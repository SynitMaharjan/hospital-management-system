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
                            Username or Email Address 
                        </label>

                        <input
                            type="text"
                            name="login"
                            class="form-control"
                            placeholder="Enter your email or username"
                            value="{{ old('login') }}"
                        >

                        @error('login')
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

                    <p class="text-center text-muted mt-3 mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}">
                            Register
                            </a>
                    </p>
                    


                </form>


            </div>

        </div>

    </div>

</div>

@endsection