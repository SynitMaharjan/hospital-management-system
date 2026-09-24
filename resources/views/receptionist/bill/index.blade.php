@extends('layouts.dashboard')

@section('page-title')
Billing
@endsection

@section('dashboard-content')

<div class="container-fluid px-0">

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-semibold mb-1">
            Billing
        </h2>

        <p class="text-muted mb-0">
            Manage patient bills and invoices.
        </p>
    </div>

    <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createBillModal"
    >
        <i class="fa-solid fa-plus me-1"></i>
        Create Bill
    </button>

</div>

{{-- Search & Filters --}}
<form
    method="GET"
    action="{{ route('receptionist.bill.index') }}"
    class="d-flex flex-wrap align-items-center gap-2 mb-4"
>

    {{-- Search --}}
    <div
        class="input-group"
        style="max-width: 500px;"
    >

        <span class="input-group-text bg-white border-end-0">
            <i class="fa-solid fa-magnifying-glass text-muted"></i>
        </span>

        <input
            type="text"
            name="search"
            class="form-control border-start-0 ps-0"
            placeholder="Search bills..."
            value="{{ request('search') }}"
            autocomplete="off"
        >

    </div>

    {{-- Search Button --}}
    <button
        type="submit"
        class="btn btn-primary"
    >
        <i class="fa-solid fa-magnifying-glass me-1"></i>
        Search
    </button>

    {{-- Clear --}}
    @if(request()->has('search'))

        <a
            href="{{ route('receptionist.bill.index') }}"
            class="btn btn-outline-secondary"
            title="Clear search"
        >
            <i class="fa-solid fa-xmark me-1"></i>
            Clear
        </a>

    @endif

</form>

{{-- Bills Table Card --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4 py-3 text-nowrap">
                            Bill #
                        </th>

                        <th class="py-3 text-nowrap">
                            Patient
                        </th>

                        <th class="py-3 text-nowrap">
                            Appointment
                        </th>

                        <th class="py-3 text-nowrap">
                            Date
                        </th>

                        <th class="py-3 text-nowrap">
                            Total
                        </th>

                        <th class="py-3 text-nowrap">
                            Status
                        </th>

                        <th class="py-3 text-nowrap">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($bills as $bill)

                        <tr>

                            {{-- Bill Number --}}
                            <td class="px-4 text-nowrap">

                                <span class="fw-medium">
                                    {{ $bill->bill_number }}
                                </span>

                            </td>

                            {{-- Patient --}}
                            <td class="text-nowrap">

                                <div class="fw-medium">
                                    {{ $bill->patient->full_name }}
                                </div>

                            </td>

                            {{-- Appointment --}}
                            <td class="text-nowrap">

                                @if($bill->appointment)

                                    {{ $bill->appointment->appointment_number }}

                                @else

                                    <span class="text-muted">
                                        N/A
                                    </span>

                                @endif

                            </td>

                            {{-- Date --}}
                            <td class="text-nowrap">

                                {{ $bill->billing_date?->format('Y-m-d') ?? 'N/A' }}

                            </td>

                            {{-- Total --}}
                            <td class="text-nowrap">

                                Rs. {{ number_format($bill->total, 2) }}

                            </td>

                            {{-- Status --}}
                            <td class="text-nowrap">

                                <span class="badge text-bg-{{
                                    match($bill->payment_status) {
                                        'paid' => 'success',
                                        'partially_paid' => 'warning',
                                        'unpaid' => 'danger',
                                        default => 'secondary'
                                    }
                                }}">

                                    {{ ucfirst($bill->payment_status) }}

                                </span>

                            </td>

                            {{-- Actions --}}
                            <td class="text-nowrap">

                                {{-- View --}}

                                <a
                                    href="{{ route('receptionist.bill.show', $bill) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="View Bill"
                                >

                                    <i class="fa-solid fa-eye"></i>

                                </a>


                                {{-- Print --}}

                                <a
                                    href="{{ route('receptionist.bill.print', $bill) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-success"
                                    title="Print Bill"
                                >
                                    <i class="fa-solid fa-print"></i>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted"
                            >

                                No bills found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- Pagination --}}

    @if($bills->hasPages())

        <div class="p-3 border-top">

            {{ $bills->links() }}

        </div>

    @endif

</div>


{{-- Create Bill Modal --}}

@include('receptionist.bill.modals.create')


</div>

@endsection
