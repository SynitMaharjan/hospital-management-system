@extends('layouts.app')

@php

use App\Enums\Gender;
use App\Enums\BloodGroup;

@endphp

@section('content')

<div class="row justify-content-center">

<div class="col-md-8 col-lg-7 py-5">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-5">

            {{-- Header --}}
            <div class="text-center mb-4">

                <h2 class="fw-bold mb-2">
                    Create Patient Account
                </h2>

                <p class="text-muted mb-0">
                    Register as a new patient to access hospital services online.
                </p>

            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form method="POST" action="{{ route('register') }}">

                @csrf

                {{-- Patient Information --}}
                <h5 class="fw-semibold mb-3">
                    Patient Information
                </h5>

                <div class="row">

                    {{-- First Name --}}
                    <div class="col-md-6 mb-3">

                        <label for="first_name" class="form-label">
                            First Name
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name') }}"
                            required
                            autofocus
                        >

                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Last Name --}}
                    <div class="col-md-6 mb-3">

                        <label for="last_name" class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name') }}"
                            required
                        >

                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 mb-3">

                        <label for="phone" class="form-label">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}"
                            required
                        >

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Date of Birth --}}
                    <div class="col-md-6 mb-3">

                        <label for="date_of_birth" class="form-label">
                            Date of Birth
                        </label>

                        <input
                            type="date"
                            id="date_of_birth"
                            name="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth') }}"
                            required
                        >

                        @error('date_of_birth')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Gender --}}
                    <div class="col-md-6 mb-3">

                        <label for="gender" class="form-label">
                            Gender
                        </label>

                        <select
                            id="gender"
                            name="gender"
                            class="form-select @error('gender') is-invalid @enderror"
                            required
                        >

                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>
                                Select Gender
                            </option>

                            @foreach (Gender::cases() as $gender)

                                <option
                                    value="{{ $gender->value }}"
                                    {{ old('gender') === $gender->value ? 'selected' : '' }}
                                >
                                    {{ $gender->value }}
                                </option>

                            @endforeach

                        </select>

                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Blood Group --}}
                    <div class="col-md-6 mb-3">

                        <label for="blood_group" class="form-label">
                            Blood Group
                        </label>

                        <select
                            id="blood_group"
                            name="blood_group"
                            class="form-select @error('blood_group') is-invalid @enderror"
                        >

                            <option value="" selected>
                                Select Blood Group
                            </option>

                            @foreach (BloodGroup::cases() as $bloodGroup)

                                <option
                                    value="{{ $bloodGroup->value }}"
                                    {{ old('blood_group') === $bloodGroup->value ? 'selected' : '' }}
                                >
                                    {{ $bloodGroup->value }}
                                </option>

                            @endforeach

                        </select>

                        @error('blood_group')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <hr class="my-4">

                {{-- Account Information --}}
                <h5 class="fw-semibold mb-3">
                    Account Information
                </h5>

                <div class="row">

                    {{-- Username --}}
                    <div class="col-md-6 mb-3">

                        <label for="username" class="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}"
                            required
                        >

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">

                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">

                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 mb-3">

                        <label for="password_confirmation" class="form-label">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            required
                        >

                    </div>

                </div>

                {{-- Submit --}}
                <div class="d-grid mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary py-2"
                    >
                        <i class="fa-solid fa-user-plus me-2"></i>
                        Continue Registration
                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- Back / Login --}}
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

@endsection
