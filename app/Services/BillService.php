<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BillService
{
    public function create(array $data): Bill
    {
        return DB::transaction(function () use ($data) {
            $patientId = $data['patient_id'];
            $appointmentId = $data['appointment_id'] ?? null;

            $patient = Patient::findOrFail($patientId);

            if ($appointmentId) {
                $appointment = Appointment::findOrFail($appointmentId);

                if ($appointment->patient_id !== $patient->id) {
                    throw ValidationException::withMessages([
                        'appointment_id' =>
                            'The appointment does not belong to the specified patient.',
                    ]);
                }
            }

            return Bill::create([
                'patient_id' => $patientId,
                'appointment_id' => $appointmentId,
                'billing_date' => $data['billing_date'],

                // Discount is entered as a percentage.
                'discount_percentage' => $data['discount_percentage'] ?? 0,

                // These are calculated by the backend later.
                'subtotal' => 0,
                'discount_amount' => 0,
                'total' => 0,

                'payment_method' => null,
                'paid_amount' => 0,
                'paid_at' => null,
            ]);
        });
    }

    public function addItem(Bill $bill, array $data): BillItem
    {
        return DB::transaction(function () use ($bill, $data) {
            $item = BillItem::create([
                'bill_id' => $bill->id,
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'],
                'total' => $data['quantity'] * $data['unit_price'],
            ]);

            $this->recalculateTotals($bill);

            return $item;
        });
    }

    public function updateItem(BillItem $item, array $data): BillItem
    {
        return DB::transaction(function () use ($item, $data) {
            $item->update([
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'],
                'total' => $data['quantity'] * $data['unit_price'],
            ]);

            $this->recalculateTotals($item->bill);

            return $item;
        });
    }

    public function removeItem(BillItem $item): void
    {
        DB::transaction(function () use ($item) {
            $bill = $item->bill;

            $item->delete();

            $this->recalculateTotals($bill);
        });
    }

    public function recordPayment(Bill $bill, array $data): void
    {
        DB::transaction(function () use ($bill, $data) {
            $amount = $data['amount'];
            $method = $data['method'];

            if ($amount <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment amount must be greater than zero.',
                ]);
            }

            $newPaidAmount = $bill->paid_amount + $amount;

            if ($newPaidAmount > $bill->total) {
                throw ValidationException::withMessages([
                    'amount' =>
                        'Payment amount cannot exceed the remaining balance.',
                ]);
            }

            $bill->update([
                'paid_amount' => $newPaidAmount,
                'payment_method' => $method,
                'paid_at' => now(),
            ]);
        });
    }

    private function recalculateTotals(Bill $bill): void
    {
        $subtotal = $bill->billItems()->sum('total');

        $discountPercentage = (float) $bill->discount_percentage;

        $discountAmount = $subtotal * ($discountPercentage / 100);

        $total = $subtotal - $discountAmount;

        $bill->update([
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total' => $total,
        ]);
    }
}