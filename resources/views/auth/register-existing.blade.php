@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-6 col-lg-5 py-5">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-5">

                <div class="text-center mb-4">

                    <div class="mb-3">
                        <i class="fa-solid fa-hospital-user fa-3x text-primary"></i>
                    </div>

                    <h2 class="fw-bold mb-2">
                        Existing Patient
                    </h2>

                    <p class="text-muted mb-0">
                        Enter your patient details to continue
                        with account registration.
                    </p>

                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0 ps-3">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                @if (session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif

                <form
                    action="{{ route('register.existing') }}"
                    method="POST"
                >

                    @csrf

                    {{-- Patient Number --}}
                    <div class="mb-3">

                        <label
                            for="patient_number"
                            class="form-label"
                        >
                            Patient Number
                        </label>

                        <input
                            type="text"
                            id="patient_number"
                            name="patient_number"
                            class="form-control @error('patient_number') is-invalid @enderror"
                            value="{{ old('patient_number') }}"
                            placeholder="e.g. PAT-000001"
                            required
                        >

                        @error('patient_number')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    {{-- Email --}}
                    <div class="mb-4">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Enter your registered email"
                            required
                        >

                        @error('email')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100 py-2"
                    >
                        <i class="fa-solid fa-arrow-right me-2"></i>
                        Continue
                    </button>

                </form>

            </div>

        </div>

        <div class="text-center mt-4">

            <small class="text-muted">

                Not an existing patient?

                <a href="{{ route('register', ['type' => 'new']) }}">
                    Register as a new patient
                </a>

            </small>

        </div>

    </div>

</div>

@endsection
