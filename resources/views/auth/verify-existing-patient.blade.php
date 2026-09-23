@extends('layouts.app')

@section('title', 'Verify Patient')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <i class="fa-solid fa-envelope-circle-check fa-3x text-primary mb-3"></i>

                        <h3 class="fw-semibold">
                            Verify Your Email
                        </h3>

                        <p class="text-muted mb-0">
                            We've sent a 6-digit verification code to your email address.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('register.existing.verify.submit') }}">

                        @csrf

                        <div class="mb-4">
                            <label for="otp" class="form-label">
                                Verification Code
                            </label>

                            <input
                                type="text"
                                name="otp"
                                id="otp"
                                class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                                placeholder="Enter 6-digit OTP"
                                maxlength="6"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                value="{{ old('otp') }}"
                            >

                            @error('otp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            Verify OTP
                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            The verification code expires in 10 minutes.
                        </small>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection