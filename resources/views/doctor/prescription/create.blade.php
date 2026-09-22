@extends('layouts.dashboard')

@section('page-title')
    Create Prescription
@endsection

@section('dashboard-content')

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">
                <i class="fa-solid fa-prescription-bottle-medical me-2"></i>
                Create Prescription
            </h4>
            <p class="text-muted mb-0">
                Create a prescription for a patient's medical record.
            </p>
        </div>

        <a href="{{ route('doctor.prescription.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Prescriptions
        </a>
    </div>

    <form
        method="POST"
        action="{{ route('doctor.prescription.store') }}"
        class="row g-4"
        id="prescription-form"
    >
        @csrf

        {{-- Medical Record --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fa-solid fa-file-medical me-2"></i>
                        Medical Record
                    </h6>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label for="medical_record_id" class="form-label fw-semibold">
                            Select Medical Record
                        </label>

                        <select
                            name="medical_record_id"
                            id="medical_record_id"
                            class="form-select @error('medical_record_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Select a medical record</option>

                            @foreach($medicalRecords as $record)
                                <option
                                    value="{{ $record->id }}"
                                    {{ old('medical_record_id', $selectedMedicalRecord?->id) == $record->id ? 'selected' : '' }}
                                    data-patient-name="{{ $record->patient->full_name }}"
                                    data-patient-number="{{ $record->patient->patient_number }}"
                                    data-phone="{{ $record->patient->phone }}"
                                >
                                    {{ $record->patient->full_name }}
                                    ({{ $record->patient->patient_number }})
                                    -
                                    {{ $record->record_date->format('M d, Y') }}
                                    -
                                    {{ Str::limit($record->diagnosis ?? 'No diagnosis', 50) }}
                                </option>
                            @endforeach
                        </select>

                        @error('medical_record_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label text-muted">
                                Patient Name
                            </label>

                            <input
                                type="text"
                                id="patient_name_display"
                                class="form-control bg-light"
                                readonly
                            >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted">
                                Patient Number
                            </label>

                            <input
                                type="text"
                                id="patient_number_display"
                                class="form-control bg-light"
                                readonly
                            >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted">
                                Phone
                            </label>

                            <input
                                type="text"
                                id="patient_phone_display"
                                class="form-control bg-light"
                                readonly
                            >
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- Prescription Details --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">

                <div class="card-header border-bottom py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fa-solid fa-file-prescription me-2"></i>
                        Prescription Details
                    </h6>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="prescription_date" class="form-label fw-semibold">
                                Prescription Date
                            </label>

                            <input
                                type="date"
                                name="prescription_date"
                                id="prescription_date"
                                class="form-control @error('prescription_date') is-invalid @enderror"
                                value="{{ old('prescription_date', now()->format('Y-m-d')) }}"
                                required
                            >

                            @error('prescription_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="notes" class="form-label fw-semibold">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                id="notes"
                                rows="2"
                                class="form-control @error('notes') is-invalid @enderror"
                                placeholder="Additional prescription notes..."
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- Medicines --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">

                <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fa-solid fa-pills me-2"></i>
                        Medicines
                    </h6>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        id="add-medicine-btn"
                    >
                        <i class="fa-solid fa-plus me-1"></i>
                        Add Medicine
                    </button>
                </div>

                <div class="card-body">

                    <div id="medicines-container"></div>

                    @error('items')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('doctor.prescription.index') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="fa-solid fa-xmark me-1"></i>
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Create Prescription
                </button>

            </div>
        </div>

    </form>

</div>

{{-- Medicine Row Template --}}
<template id="medicine-template">

    <div class="medicine-row row g-3 mb-3 p-3 border rounded bg-light">

        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Medicine Name
            </label>

            <input
                type="text"
                name="items[__INDEX__][medicine_name]"
                class="form-control"
                placeholder="e.g. Paracetamol"
                required
            >
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Dosage
            </label>

            <input
                type="text"
                name="items[__INDEX__][dosage]"
                class="form-control"
                placeholder="e.g. 500 mg"
                required
            >
        </div>

        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Frequency
            </label>

            <input
                type="text"
                name="items[__INDEX__][frequency]"
                class="form-control"
                placeholder="e.g. 3 times/day"
                required
            >
        </div>

        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Duration
            </label>

            <input
                type="text"
                name="items[__INDEX__][duration]"
                class="form-control"
                placeholder="e.g. 5 days"
                required
            >
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">
                Instructions
            </label>

            <input
                type="text"
                name="items[__INDEX__][instructions]"
                class="form-control"
                placeholder="e.g. After meals"
            >
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button
                type="button"
                class="btn btn-outline-danger w-100 remove-medicine-btn"
                title="Remove medicine"
            >
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>

    </div>

</template>

@endsection