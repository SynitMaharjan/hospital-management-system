<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AdminDashboardService
{
    /**
     * Get cached statistics for the admin dashboard.
     */
    public function getStatistics(): array
    {
        return Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'totalStaff' => User::whereIn('role', [
                    'doctor',
                    'nurse',
                    'receptionist',
                ])->count(),

                'totalDoctors' => User::where('role', 'doctor')->count(),

                'totalNurses' => User::where('role', 'nurse')->count(),

                'totalReceptionists' => User::where(
                    'role',
                    'receptionist'
                )->count(),

                'totalPatients' => User::where(
                    'role',
                    'patient'
                )->count(),
            ];
        });
    }
}
