@extends('layouts.dashboard')

@section('page-title')
Bill {{ $bill->bill_number }}
@endsection

@section('dashboard-content')

<div class="container-fluid px-0">

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-semibold mb-1">
            Bill {{ $bill->bill_number }}
        </h2>

        <p class="text-muted mb-0">
            View bill details and payment information.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('receptionist.bill.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Bills
        </a>

        <button
            type="button"
            class="btn btn-primary"
            onclick="window.print()"
        >
            <i class="fa-solid fa-print me-1"></i>
            Print
        </button>

    </div>

</div>

{{-- Success Message --}}
@if (session('success'))

    <div
        class="alert alert-success alert-dismissible fade show"
        role="alert"
    >
        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>
    </div>

@endif

<div class="row g-4">

    {{-- Bill Information --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="fa-solid fa-file-invoice me-2"></i>
                    Bill Details
                </h5>

                <span
                    class="badge
                    @if ($bill->payment_status === 'paid')
                        bg-success
                    @elseif ($bill->payment_status === 'partially_paid')
                        bg-warning text-dark
                    @else
                        bg-danger
                    @endif"
                >
                    {{ ucfirst(str_replace('_', ' ', $bill->payment_status)) }}
                </span>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Bill Number
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->bill_number }}
                        </div>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted">
                            Billing Date
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->billing_date->format('M d, Y') }}
                        </div>

                    </div>

                    @if ($bill->appointment)

                        <div class="col-md-6">

                            <small class="text-muted">
                                Appointment
                            </small>

                            <div class="fw-semibold">
                                {{ $bill->appointment->appointment_number }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Doctor
                            </small>

                            <div class="fw-semibold">
                                Dr. {{ $bill->appointment->doctor->user->name }}
                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- Patient Information --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="fa-solid fa-user me-2"></i>
                    Patient Information
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Patient Number
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->patient->patient_number }}
                        </div>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted">
                            Name
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->patient->full_name }}
                        </div>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted">
                            Phone
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->patient->phone }}
                        </div>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted">
                            Email
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->patient->email ?? 'No email provided' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Bill Items --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="fa-solid fa-list me-2"></i>
                    Bill Items
                </h5>

                <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addItemModal"
                >
                    <i class="fa-solid fa-plus me-1"></i>
                    Add Item
                </button>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Description</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($bill->billItems as $item)

                                <tr>

                                    <td>
                                        {{ $item->description }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="text-end">
                                        Rs. {{ number_format($item->unit_price, 2) }}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        Rs. {{ number_format($item->total, 2) }}
                                    </td>

                                    <td class="text-end">

                                        <form
                                            method="POST"
                                            action="{{ route('receptionist.bill.item.destroy', [$bill, $item]) }}"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Remove this item from the bill?')"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center text-muted py-4"
                                    >
                                        No items have been added to this bill yet.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Totals --}}
            <div class="card-footer">

                <div class="row justify-content-end">

                    <div class="col-md-5">

                        <div class="d-flex justify-content-between mb-2">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                Rs. {{ number_format($bill->subtotal, 2) }}
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-2">

                            <span>
                                Discount
                                ({{ number_format($bill->discount_percentage, 2) }}%)
                            </span>

                            <strong class="text-danger">
                                - Rs. {{ number_format($bill->discount_amount, 2) }}
                            </strong>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">

                            <span class="fw-bold">
                                Total
                            </span>

                            <strong class="fs-5">
                                Rs. {{ number_format($bill->total, 2) }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Payment Information --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="fa-solid fa-credit-card me-2"></i>
                    Payment Information
                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <small class="text-muted">
                        Total Amount
                    </small>

                    <div class="fs-4 fw-bold">
                        Rs. {{ number_format($bill->total, 2) }}
                    </div>

                </div>

                <div class="mb-3">

                    <small class="text-muted">
                        Paid Amount
                    </small>

                    <div class="fs-5 fw-semibold text-success">
                        Rs. {{ number_format($bill->paid_amount, 2) }}
                    </div>

                </div>

                <div class="mb-3">

                    <small class="text-muted">
                        Remaining Amount
                    </small>

                    <div class="fs-5 fw-semibold text-danger">
                        Rs. {{ number_format($bill->remaining_amount, 2) }}
                    </div>

                </div>

                <div class="mb-3">

                    <small class="text-muted">
                        Payment Status
                    </small>

                    <div>

                        @if ($bill->payment_status === 'paid')

                            <span class="badge bg-success">
                                Paid
                            </span>

                        @elseif ($bill->payment_status === 'partially_paid')

                            <span class="badge bg-warning text-dark">
                                Partially Paid
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Unpaid
                            </span>

                        @endif

                    </div>

                </div>

                @if ($bill->payment_method)

                    <div class="mb-3">

                        <small class="text-muted">
                            Payment Method
                        </small>

                        <div class="fw-semibold">
                            {{ ucfirst($bill->payment_method) }}
                        </div>

                    </div>

                @endif

                @if ($bill->paid_at)

                    <div class="mb-3">

                        <small class="text-muted">
                            Paid At
                        </small>

                        <div class="fw-semibold">
                            {{ $bill->paid_at->format('M d, Y h:i A') }}
                        </div>

                    </div>

                @endif

                @if ($bill->payment_status !== 'paid')

                    <button
                        type="button"
                        class="btn btn-success w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#paymentModal"
                    >
                        <i class="fa-solid fa-money-bill me-1"></i>
                        Record Payment
                    </button>

                @endif

            </div>

        </div>

    </div>

</div>

</div>

{{-- Add Item Modal --}}

<div
    class="modal fade"
    id="addItemModal"
    tabindex="-1"
    aria-labelledby="addItemModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="addItemModalLabel">
                <i class="fa-solid fa-plus me-2"></i>
                Add Bill Item
            </h5>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>

        </div>

        <form
            method="POST"
            action="{{ route('receptionist.bill.item.store', $bill) }}"
        >

            @csrf

            <div class="modal-body">

                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Description <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="description"
                        class="form-control"
                        value="{{ old('description') }}"
                        placeholder="e.g. Consultation"
                        required
                    >

                    @error('description')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-bold">
                            Quantity <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            class="form-control"
                            value="{{ old('quantity', 1) }}"
                            min="0.01"
                            step="0.01"
                            required
                        >

                        @error('quantity')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-bold">
                            Unit Price <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="unit_price"
                            class="form-control"
                            value="{{ old('unit_price') }}"
                            min="0"
                            step="0.01"
                            required
                        >

                        @error('unit_price')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fa-solid fa-plus me-1"></i>
                    Add Item
                </button>

            </div>

        </form>

    </div>
</div>

</div>

{{-- Payment Modal --}}

<div
    class="modal fade"
    id="paymentModal"
    tabindex="-1"
    aria-labelledby="paymentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="paymentModalLabel">
                <i class="fa-solid fa-money-bill me-2"></i>
                Record Payment
            </h5>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>

        </div>

        <form
            method="POST"
            action="{{ route('receptionist.bill.payment', $bill) }}"
        >

            @csrf

            <div class="modal-body">

                <div class="alert alert-light border">

                    <div class="d-flex justify-content-between">

                        <span>
                            Remaining Balance
                        </span>

                        <strong>
                            Rs. {{ number_format($bill->remaining_amount, 2) }}
                        </strong>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Payment Amount <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        min="0.01"
                        max="{{ $bill->remaining_amount }}"
                        step="0.01"
                        required
                    >

                    @error('amount')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Payment Method <span class="text-danger">*</span>
                    </label>

                    <select
                        name="method"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Payment Method
                        </option>

                        <option value="cash">
                            Cash
                        </option>

                        <option value="card">
                            Card
                        </option>

                        <option value="other">
                            Other
                        </option>

                    </select>

                    @error('method')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    <i class="fa-solid fa-check me-1"></i>
                    Record Payment
                </button>

            </div>

        </form>

    </div>
</div>

</div>

@endsection
