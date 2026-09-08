<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = "admin";
    case DOCTOR = "doctor";
    case NURSE = "nurse";
    case RECEPTIONIST = "receptionist";
    case PATIENT = "patient";
    
    public function badgeColor(): string
    {
        return match ($this) {
            Role::ADMIN => 'primary',
            Role::DOCTOR => 'success',
            Role::NURSE => 'info',
            Role::RECEPTIONIST => 'warning',
            Role::PATIENT => 'secondary',
        };
}

}