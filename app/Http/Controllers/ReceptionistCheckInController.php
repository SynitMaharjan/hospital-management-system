<?php

namespace App\Http\Controllers;

use App\Enums\CheckInStatus;
use App\Http\Requests\StoreCheckInRequest;
use App\Models\Appointment;
use App\Models\CheckIn;
use App\Services\CheckInService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReceptionistCheckInController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected CheckInService $checkInService)
    {
    }

    /**
     * Display today's appointments eligible for check-in
     * and patients who are already checked in.
     */
    public function index()
    {
        $today = now()->toDateString();

        // Today's confirmed appointments that have not been checked in yet.
        $appointments = Appointment::with([
            'patient.user',
            'doctor.user',
            'doctor.department'
        ])
            ->whereDate('appointment_date', $today)
            ->where('status', 'confirmed')
            ->whereNotExists(function ($query) {
                $query->selectRaw(1)
                    ->from('check_ins')
                    ->whereRaw('check_ins.appointment_id = appointments.id');
            })
            ->orderBy('appointment_time')
            ->get();

        // Patients who have already checked in today.
        $checkIns = CheckIn::with([
            'patient',
            'appointment.doctor.user',
            'appointment.doctor.department',
        ])
            ->whereDate('checked_in_at', $today)
            ->latest('checked_in_at')
            ->get();

        return view(
            'receptionist.check-in.index',
            compact('appointments', 'checkIns')
        );
    }

    /**
     * Store a newly checked-in appointment.
     */
    public function store(StoreCheckInRequest $request)
    {
        $this->checkInService->checkIn(
            $request->validated()
        );

        return redirect()
            ->route('receptionist.check-in.index')
            ->with(
                'success',
                'Patient checked in successfully.'
            );
    }

    /**
     * Update the status of an existing check-in.
     */
    public function updateStatus(Request $request, CheckIn $checkIn)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::enum(CheckInStatus::class),
            ],
        ]);

        $this->checkInService->updateStatus(
            $checkIn,
            CheckInStatus::from($validated['status'])
        );

        return redirect()
            ->route('receptionist.check-in.index')
            ->with(
                'success',
                'Check-in status updated successfully.'
            );
    }
}
