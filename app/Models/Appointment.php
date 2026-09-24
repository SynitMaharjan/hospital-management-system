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
        "appointment_number",
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function checkIn()
    {
        return $this->hasOne(CheckIn::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
    protected static function booted()
    {
        static::created(function ($appointment) {
            $appointment->update([
                'appointment_number' => 'APT-' . str_pad(
                    $appointment->id,
                    5,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);
        });
    }

    use HasFactory;
}
