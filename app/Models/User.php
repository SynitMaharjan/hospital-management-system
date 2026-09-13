<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\Role;
use App\Models\AuditLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'name',
        'username',
        'email',
        'password',
        'role',
        'must_change_password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
//appends 
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'must_change_password' => 'boolean',
        'role' => Role::class,
    ];

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
    
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
    
    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }
    
    public function getProfilePictureUrlAttribute(): string
    {
        if (!$this->profile_picture) {
            return asset('images/default-profile.jpg');
        }

        if (!file_exists(public_path('storage/' . $this->profile_picture))) {
            return asset('images/default-profile.jpg');
        }

        return asset('storage/' . $this->profile_picture);
    }
}
