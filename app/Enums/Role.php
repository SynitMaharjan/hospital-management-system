<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = "admin";
    case DOCTOR = "doctor";
    case NURSE = "nurse";
    case RECEPTIONIST = "receptionist";
    case PATIENT = "patient";
}