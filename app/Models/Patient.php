<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'appointment_id',
        'phone',
        'date_of_birth',
        'gender',
    ];

    protected $casts = [
        'gender' => Gender::class,
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
