<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use App\Enums\Gender;
use App\Enums\BloodGroup;

class Patient extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
            'user_id',
            'patient_number',
            'first_name',
            'last_name',
            'phone',
            'email',
            'date_of_birth',
            'gender',
            'blood_group',
        ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gender' => Gender::class,
        'blood_group' => BloodGroup::class,
    ];

    public function latestAppointment()
    {
        return $this->hasOne(Appointment::class)->latestOfMany();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifications()
    {
    return $this->hasMany(PatientVerification::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}"
        );
    }
    
    protected static function booted()
    {
        static::created(function ($patient) {
            $patient->update([
                'patient_number' => 'PAT-' . str_pad(
                    $patient->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);
        });
    }
}
