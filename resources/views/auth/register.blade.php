@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-6 col-lg-5 py-5">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-5">

                <h2 class="text-center fw-bold mb-2">
                    Create Patient Account
                </h2>

                <p class="text-center text-muted mb-4">
                    Choose an option to continue with registration.
                </p>

                <div class="d-grid gap-3">

                    {{-- New Patient --}}
                    <a
                        href="{{ route('register', ['type' => 'new']) }}"
                        class="btn btn-primary py-3"
                    >
                        <i class="fa-solid fa-user-plus me-2"></i>
                        I'm a New Patient
                    </a>

                    {{-- Existing Patient --}}
                    <a
                        href="{{ route('register', ['type' => 'existing']) }}"
                        class="btn btn-outline-primary py-3"
                    >
                        <i class="fa-solid fa-hospital-user me-2"></i>
                        I've Visited This Hospital Before
                    </a>

                </div>

            </div>

        </div>

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

@endsection