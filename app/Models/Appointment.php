<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    protected $fillable = [
        "patient_id",
        "doctor_id",
        "appointment_date",
        "appointment_time",
        "status",
        "reason",
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    use HasFactory;
}
