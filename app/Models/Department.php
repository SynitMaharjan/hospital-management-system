<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_number',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function nurses()
    {
        return $this->hasMany(Nurse::class);
    }

    protected static function booted()
    {
        static::created(function ($department) {
            $department->update([
                'department_number' => 'DEP-' . str_pad(
                    $department->id,
                    5,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);
        });
    }
}