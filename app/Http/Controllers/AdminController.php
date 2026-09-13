<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\AdminDashboardService;
use App\Models\AuditLog;

class AdminController extends Controller
{
    public function __construct(
        protected AdminDashboardService $dashboardService
    ) {}

    public function dashboard()
    {
        $stats = $this->dashboardService->getStatistics();

        $departments = Department::orderBy('name')->get();

        $recentAuditLogs = AuditLog::with('user')
            ->latest()
            ->take(3)
            ->get();

        return view('admin.dashboard', [
            'totalStaff' => $stats['totalStaff'],
            'totalDoctors' => $stats['totalDoctors'],
            'totalNurses' => $stats['totalNurses'],
            'totalReceptionists' => $stats['totalReceptionists'],
            'totalPatients' => $stats['totalPatients'],
            'departments' => $departments,
            'recentAuditLogs' => $recentAuditLogs,
        ]);
    }
}
