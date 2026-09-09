@extends('layouts.app')

@php
use App\Enums\Gender;
@endphp

@section('content')

<div class="row justify-content-center">


<div class="col-md-6 col-lg-5 py-5">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-5">

            <h2 class="text-center fw-bold mb-2">
                Create Account
            </h2>

            <p class="text-center text-muted mb-4">
                Register to access the Hospital Management System.
            </p>


            <form method="POST" action="{{ route('register') }}">

                @csrf


                {{-- Full Name --}}
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Username --}}
                <div class="mb-3">

                    <label
                        for="username"
                        class="form-label"
                    >
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control @error('username') is-invalid @enderror"
                        placeholder="Choose a username"
                        value="{{ old('username') }}"
                    >

                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="mb-3">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Phone --}}
                <div class="mb-3">

                    <label
                        for="phone"
                        class="form-label"
                    >
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        placeholder="Enter your phone number"
                        value="{{ old('phone') }}"
                    >

                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Date of Birth --}}
                <div class="mb-3">

                    <label
                        for="date_of_birth"
                        class="form-label"
                    >
                        Date of Birth
                    </label>

                    <input
                        type="date"
                        name="date_of_birth"
                        id="date_of_birth"
                        class="form-control @error('date_of_birth') is-invalid @enderror"
                        value="{{ old('date_of_birth') }}"
                    >

                    @error('date_of_birth')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Gender --}}
                <div class="mb-4">

                    <label
                        for="gender"
                        class="form-label"
                    >
                        Gender
                    </label>

                    <select
                        name="gender"
                        id="gender"
                        class="form-select @error('gender') is-invalid @enderror"
                    >

                        <option value="">
                            Select Gender
                        </option>

                        @foreach(Gender::cases() as $gender)

                            <option
                                value="{{ $gender->value }}"
                                {{ old('gender') === $gender->value ? 'selected' : '' }}
                            >
                                {{ ucfirst($gender->value) }}
                            </option>

                        @endforeach

                    </select>

                    @error('gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="mb-3">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Create a password"
                    >

                    <small class="text-muted">
                        Password must contain at least 8 characters,
                        including one uppercase letter, one lowercase
                        letter, one number, and one special character
                        (@$!%*?&).
                    </small>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Confirm Password --}}
                <div class="mb-4">

                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirm your password"
                    >

                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Register Button --}}
                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    Create Account
                </button>

            </form>


            {{-- Login Link --}}
            <div class="text-center mt-4">

                <small class="text-muted">

                    Already have an account?

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </small>

            </div>

        </div>

    </div>

</div>


</div>

@endsection
