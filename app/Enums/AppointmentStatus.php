<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case PENDING = "pending";
    case CONFIRMED = "confirmed";
    case COMPLETED = "completed";
    case CANCELLED = "cancelled";
}