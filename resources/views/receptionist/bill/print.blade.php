<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Bill {{ $bill->bill_number }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
            color: #212529;
            font-size: 14px;
        }

        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background: #ffffff;
        }

        .hospital-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .hospital-header h1 {
            margin: 0 0 5px;
            font-size: 26px;
        }

        .hospital-header p {
            margin: 3px 0;
            color: #666;
        }

        .bill-header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .bill-header h2 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        .bill-meta {
            text-align: right;
        }

        .bill-meta p,
        .info p {
            margin: 4px 0;
        }

        .section {
            margin-top: 25px;
        }

        .section-title {
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
            font-weight: bold;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 30px;
        }

        .label {
            color: #777;
            font-size: 12px;
        }

        .value {
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            text-align: left;
            background: #f8f9fa;
            font-size: 13px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            width: 320px;
            margin-left: auto;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .grand-total {
            margin-top: 8px;
            padding-top: 10px;
            border-top: 2px solid #212529;
            font-size: 18px;
            font-weight: bold;
        }

        .payment-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #777;
            font-size: 12px;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            border: 0;
            border-radius: 5px;
            background: #0d6efd;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        @media print {

            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                padding: 0;
                background: #ffffff;
            }

            .invoice {
                max-width: none;
                padding: 0;
            }

            .print-button {
                display: none;
            }

        }

        @media (max-width: 600px) {

            body {
                padding: 10px;
            }

            .invoice {
                padding: 20px;
            }

            .bill-header {
                flex-direction: column;
            }

            .bill-meta {
                text-align: left;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .totals {
                width: 100%;
            }

        }

    </style>

</head>

<body>

    <button
        type="button"
        class="print-button"
        onclick="window.print()"
    >
        Print Bill
    </button>

    <div class="invoice">

        {{-- Hospital Header --}}
        <div class="hospital-header">

            <h1>
                Hospital Management System
            </h1>

            <p>
                Hospital Invoice
            </p>

        </div>

        {{-- Bill Header --}}
        <div class="bill-header">

            <div>

                <h2>
                    BILL
                </h2>

                <p>
                    <strong>
                        {{ $bill->bill_number }}
                    </strong>
                </p>

            </div>

            <div class="bill-meta">

                <p>
                    <span class="label">
                        Billing Date:
                    </span>

                    <strong>
                        {{ $bill->billing_date->format('M d, Y') }}
                    </strong>
                </p>

                @if ($bill->appointment)

                    <p>
                        <span class="label">
                            Appointment:
                        </span>

                        <strong>
                            {{ $bill->appointment->appointment_number }}
                        </strong>
                    </p>

                @endif

            </div>

        </div>

        {{-- Patient Information --}}
        <div class="section">

            <div class="section-title">
                Patient Information
            </div>

            <div class="info-grid">

                <div class="info">

                    <p>
                        <span class="label">
                            Patient Number
                        </span>
                    </p>

                    <p class="value">
                        {{ $bill->patient->patient_number }}
                    </p>

                </div>

                <div class="info">

                    <p>
                        <span class="label">
                            Patient Name
                        </span>
                    </p>

                    <p class="value">
                        {{ $bill->patient->full_name }}
                    </p>

                </div>

                <div class="info">

                    <p>
                        <span class="label">
                            Phone
                        </span>
                    </p>

                    <p class="value">
                        {{ $bill->patient->phone }}
                    </p>

                </div>

                <div class="info">

                    <p>
                        <span class="label">
                            Email
                        </span>
                    </p>

                    <p class="value">
                        {{ $bill->patient->email ?? 'No email provided' }}
                    </p>

                </div>

                @if ($bill->appointment)

                    <div class="info">

                        <p>
                            <span class="label">
                                Doctor
                            </span>
                        </p>

                        <p class="value">
                            Dr. {{ $bill->appointment->doctor->user->name }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

        {{-- Bill Items --}}
        <div class="section">

            <div class="section-title">
                Bill Items
            </div>

            <table>

                <thead>

                    <tr>

                        <th>
                            Description
                        </th>

                        <th class="text-center">
                            Quantity
                        </th>

                        <th class="text-right">
                            Unit Price
                        </th>

                        <th class="text-right">
                            Total
                        </th>

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

                            <td class="text-right">
                                Rs.
                                {{ number_format($item->unit_price, 2) }}
                            </td>

                            <td class="text-right">
                                Rs.
                                {{ number_format($item->total, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center"
                            >
                                No items have been added to this bill.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Totals --}}
        <div class="totals">

            <div class="total-row">

                <span>
                    Subtotal
                </span>

                <strong>
                    Rs. {{ number_format($bill->subtotal, 2) }}
                </strong>

            </div>

            <div class="total-row">

                <span>
                    Discount
                    ({{ number_format($bill->discount_percentage, 2) }}%)
                </span>

                <strong>
                    - Rs. {{ number_format($bill->discount_amount, 2) }}
                </strong>

            </div>

            <div class="total-row grand-total">

                <span>
                    Total
                </span>

                <strong>
                    Rs. {{ number_format($bill->total, 2) }}
                </strong>

            </div>

        </div>

        {{-- Payment Information --}}
        <div class="payment-section">

            <div class="section-title">
                Payment Information
            </div>

            <div class="info-grid">

                <div class="info">

                    <p>
                        <span class="label">
                            Payment Status
                        </span>
                    </p>

                    <p class="value status">
                        {{ ucfirst(str_replace('_', ' ', $bill->payment_status)) }}
                    </p>

                </div>

                <div class="info">

                    <p>
                        <span class="label">
                            Payment Method
                        </span>
                    </p>

                    <p class="value">
                        {{ $bill->payment_method
                            ? ucfirst($bill->payment_method)
                            : 'Not paid' }}
                    </p>

                </div>

                <div class="info">

                    <p>
                        <span class="label">
                            Paid Amount
                        </span>
                    </p>

                    <p class="value">
                        Rs. {{ number_format($bill->paid_amount, 2) }}
                    </p>

                </div>

                <div class="info">

                    <p>
                        <span class="label">
                            Remaining Amount
                        </span>
                    </p>

                    <p class="value">
                        Rs. {{ number_format($bill->remaining_amount, 2) }}
                    </p>

                </div>

                @if ($bill->paid_at)

                    <div class="info">

                        <p>
                            <span class="label">
                                Paid At
                            </span>
                        </p>

                        <p class="value">
                            {{ $bill->paid_at->format('M d, Y h:i A') }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

        {{-- Footer --}}
        <div class="footer">

            <p>
                Thank you for choosing our hospital.
            </p>

            <p>
                This is a computer-generated bill.
            </p>

        </div>

    </div>

    <script>

        window.onload = function () {
            window.print();
        };

    </script>

</body>

</html>
