<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'department_id',
        'phone',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
