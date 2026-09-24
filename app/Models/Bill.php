<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_number',
        'patient_id',
        'appointment_id',
        'billing_date',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'total',
        'payment_method',
        'paid_amount',
        'paid_at',
    ];

    protected $casts = [
        'billing_date' => 'date',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($bill) {
            if (! $bill->bill_number) {
                $bill->bill_number = 'BILL-' . str_pad(
                    (static::max('id') ?? 0) + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }

    public function calculateSubtotal(): float
    {
        return (float) $this->billItems->sum('total');
    }

    public function calculateDiscountAmount(): float
    {
        return $this->calculateSubtotal()
            * ((float) $this->discount_percentage / 100);
    }

    public function calculateTotal(): float
    {
        return $this->calculateSubtotal()
            - $this->calculateDiscountAmount();
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, (float) $this->total - (float) $this->paid_amount);
    }

    public function getPaymentStatusAttribute(): string
    {
        if ($this->paid_amount <= 0) {
            return 'unpaid';
        }

        if ($this->paid_amount >= $this->total) {
            return 'paid';
        }

        return 'partially_paid';
    }
}