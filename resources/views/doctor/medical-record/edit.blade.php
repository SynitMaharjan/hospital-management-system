@extends('layouts.dashboard')

@section('page-title')
    Edit Medical Record
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <div class="text-primary fs-4">
                    <i class="fa-solid fa-file-pen"></i>
                </div>

                <h2 class="fw-semibold mb-0">
                    Edit Medical Record
                </h2>

            </div>

            <p class="text-muted mb-0">
                {{ $medicalRecord->patient->full_name }}
                <span class="mx-1">•</span>
                {{ $medicalRecord->record_date->format('M d, Y') }}
            </p>

        </div>


        <a
            href="{{ route('doctor.medical-record.show', $medicalRecord) }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Record
        </a>

    </div>


    <form
        method="POST"
        action="{{ route('doctor.medical-record.update', $medicalRecord) }}"
    >

        @csrf
        @method('PUT')


        <div class="row g-4">

            <!-- Record Information -->
            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

                        <div class="d-flex align-items-center gap-2">

                            <div class="text-primary">
                                <i class="fa-solid fa-stethoscope fs-5"></i>
                            </div>

                            <div>

                                <h5 class="fw-semibold mb-1">
                                    Clinical Details
                                </h5>

                                <small class="text-muted">
                                    Update the clinical information for this patient visit
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body px-4 pb-4">

                        <!-- Record Date -->
                        <div class="mb-4">

                            <label
                                for="record_date"
                                class="form-label fw-medium"
                            >
                                Record Date
                                <span class="text-danger">*</span>
                            </label>

                            <div class="row">

                                <div class="col-lg-6 col-md-8">

                                    <input
                                        type="date"
                                        name="record_date"
                                        id="record_date"
                                        class="form-control"
                                        value="{{ old('record_date', $medicalRecord->record_date->format('Y-m-d')) }}"
                                        required
                                    >

                                </div>

                            </div>

                            @error('record_date')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Chief Complaint -->
                        <div class="mb-4">

                            <label
                                for="chief_complaint"
                                class="form-label fw-medium"
                            >
                                Chief Complaint / Visit Reason
                            </label>

                            <textarea
                                name="chief_complaint"
                                id="chief_complaint"
                                class="form-control"
                                rows="3"
                                placeholder="Primary reason for the visit..."
                            >{{ old('chief_complaint', $medicalRecord->chief_complaint) }}</textarea>

                            @error('chief_complaint')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Symptoms -->
                        <div class="mb-4">

                            <label
                                for="symptoms"
                                class="form-label fw-medium"
                            >
                                Symptoms
                            </label>

                            <textarea
                                name="symptoms"
                                id="symptoms"
                                class="form-control"
                                rows="3"
                                placeholder="Patient's reported symptoms..."
                            >{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>

                            @error('symptoms')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Diagnosis -->
                        <div class="mb-4">

                            <label
                                for="diagnosis"
                                class="form-label fw-medium"
                            >
                                Diagnosis
                            </label>

                            <textarea
                                name="diagnosis"
                                id="diagnosis"
                                class="form-control"
                                rows="3"
                                placeholder="Clinical diagnosis..."
                            >{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>

                            @error('diagnosis')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Examination -->
                        <div class="mb-4">

                            <label
                                for="examination"
                                class="form-label fw-medium"
                            >
                                Examination Findings
                            </label>

                            <textarea
                                name="examination"
                                id="examination"
                                class="form-control"
                                rows="3"
                                placeholder="Physical examination findings..."
                            >{{ old('examination', $medicalRecord->examination) }}</textarea>

                            @error('examination')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Treatment -->
                        <div class="mb-4">

                            <label
                                for="treatment"
                                class="form-label fw-medium"
                            >
                                Treatment Plan
                            </label>

                            <textarea
                                name="treatment"
                                id="treatment"
                                class="form-control"
                                rows="3"
                                placeholder="Prescribed treatment, procedures, referrals..."
                            >{{ old('treatment', $medicalRecord->treatment) }}</textarea>

                            @error('treatment')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Additional Notes -->
                        <div>

                            <label
                                for="notes"
                                class="form-label fw-medium"
                            >
                                Additional Notes
                            </label>

                            <textarea
                                name="notes"
                                id="notes"
                                class="form-control"
                                rows="3"
                                placeholder="Any additional clinical notes..."
                            >{{ old('notes', $medicalRecord->notes) }}</textarea>

                            @error('notes')

                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            <!-- Actions -->
            <div class="col-12">

                <div class="d-flex flex-wrap gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Save Changes
                    </button>

                    <a
                        href="{{ route('doctor.medical-record.show', $medicalRecord) }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="fa-solid fa-xmark me-1"></i>
                        Cancel
                    </a>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
