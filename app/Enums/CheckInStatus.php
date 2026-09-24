<?php

namespace App\Enums;

enum CheckInStatus: string
{
    case WAITING = 'waiting';
    case IN_CONSULTATION = 'in_consultation';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}