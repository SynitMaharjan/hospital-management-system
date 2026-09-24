<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->total = $item->quantity * $item->unit_price;
        });

        static::updating(function ($item) {
            if ($item->isDirty('quantity') || $item->isDirty('unit_price')) {
                $item->total = $item->quantity * $item->unit_price;
            }
        });
    }
}