@extends('layouts.dashboard')

@section('page-title', 'My Profile')

@section('dashboard-content')

<div class="container-fluid px-0">

{{-- Page Header --}}
<div class="mb-4">
    <h4 class="fw-semibold mb-1">My Profile</h4>
    <p class="text-muted mb-0">
        Manage your profile information and profile picture.
    </p>
</div>

<div class="row g-4">

    {{-- Profile Card --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">

                {{-- Profile Picture --}}
                <div class="mb-3">
                    <img
                        src="{{ $user->profile_picture_url }}"
                        alt="Profile Picture"
                        id="profilePreview"
                        class="rounded-circle border shadow-sm"
                        style="
                            width: 160px;
                            height: 160px;
                            object-fit: cover;
                        "
                    >
                </div>

                {{-- Change Photo --}}
                <form
                    action="{{ route('profile.picture.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="profilePictureForm"
                >
                    @csrf

                    <input
                        type="file"
                        name="profile_picture"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="d-none"
                        id="profilePicInput"
                    >

                    <button
                        type="button"
                        class="btn btn-outline-primary btn-sm px-3"
                        id="changePhotoButton"
                    >
                        <i class="fas fa-camera me-1"></i>
                        Change Photo
                    </button>

                    <div class="text-muted small mt-2">
                        JPG, PNG or WEBP · Max 2 MB
                    </div>

                </form>

                <hr class="my-4">

                {{-- Name --}}
                <h5 class="fw-semibold mb-1">
                    {{ $user->name }}
                </h5>

                {{-- Username --}}
                <p class="text-muted mb-2">
                    {{ '@' . $user->username }}
                </p>

                {{-- Role --}}
                <span class="badge bg-{{ $user->role->badgeColor() }} px-3 py-2">
                    {{ ucfirst($user->role->value) }}
                </span>

                <hr class="my-4">

                {{-- Employee ID --}}
                <div class="text-muted small mb-1">
                    <i class="fas fa-id-badge me-1"></i>
                    Employee ID
                </div>

                <div class="fw-semibold">
                    {{ $user->employee_id }}
                </div>

            </div>
        </div>

    </div>

    {{-- Account Information --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <h5 class="fw-semibold mb-1">
                    Personal Information
                </h5>

                <p class="text-muted small mb-0">
                    Your account information
                </p>

            </div>

            <div class="card-body p-4">

                <div class="row g-4">

                    {{-- Full Name --}}
                    <div class="col-md-6">
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fas fa-user me-2"></i>
                                Full Name
                            </div>

                            <div class="fw-semibold">
                                {{ $user->name }}
                            </div>
                        </div>
                    </div>

                    {{-- Username --}}
                    <div class="col-md-6">
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fas fa-at me-2"></i>
                                Username
                            </div>

                            <div class="fw-semibold">
                                {{ '@' . $user->username }}
                            </div>
                        </div>
                    </div>

                    {{-- Employee ID --}}
                    <div class="col-md-6">
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fas fa-id-card me-2"></i>
                                Employee ID
                            </div>

                            <div class="fw-semibold">
                                {{ $user->employee_id }}
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fas fa-envelope me-2"></i>
                                Email Address
                            </div>

                            <div class="fw-semibold">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fas fa-user-tag me-2"></i>
                                Role
                            </div>

                            <div class="fw-semibold">
                                {{ ucfirst($user->role->value) }}
                            </div>
                        </div>
                    </div>

                    {{-- Account Status --}}
                    <div class="col-md-6">
                        <div>
                            <div class="text-muted small mb-1">
                                <i class="fas fa-circle-check me-2"></i>
                                Account Status
                            </div>

                            <div>
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@endsection
