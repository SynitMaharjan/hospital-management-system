@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-6 col-lg-5 py-5">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-5">

                <div class="text-center mb-4">

                    <div class="mb-3">
                        <i class="fa-solid fa-user-lock fa-3x text-primary"></i>
                    </div>

                    <h2 class="fw-bold mb-2">
                        Create Your Account
                    </h2>

                    <p class="text-muted mb-0">
                        Your patient record has been verified.
                        Create your login credentials to continue.
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

                <form
                    action="{{ route('register.existing.account') }}"
                    method="POST"
                >

                    @csrf

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
                            id="username"
                            name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}"
                            placeholder="Choose a username"
                            autocomplete="username"
                            required
                        >

                        @error('username')
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
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Create a password"
                            autocomplete="new-password"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
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
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirm your password"
                            autocomplete="new-password"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100 py-2"
                    >
                        <i class="fa-solid fa-user-check me-2"></i>
                        Create Account
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

