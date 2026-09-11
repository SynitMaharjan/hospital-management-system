<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Department;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Appointment::with(
        'patient.user',
        'doctor.user',
        'doctor.department'
    );

    // Search
    if (request('search')) {

        $search = request('search');

        $query->where(function ($q) use ($search) {

            $q->whereHas('patient.user', function ($q) use ($search) {

                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('username', 'ilike', "%{$search}%");

            })

            ->orWhereHas('doctor.user', function ($q) use ($search) {

                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('username', 'ilike', "%{$search}%");

            });

        });
    }


    // Status filter
    if (request('status')) {

        $query->where(
            'status',
            request('status')
        );
    }


    // Doctor filter
    if (request('doctor')) {

        $query->where(
            'doctor_id',
            request('doctor')
        );
    }


    // Department filter
    if (request('department')) {

        $departmentId = request('department');

        $query->whereHas(
            'doctor',
            function ($q) use ($departmentId) {

                $q->where(
                    'department_id',
                    $departmentId
                );

            }
        );
    }


    // Date filter
    if (request('date')) {

        $query->whereDate(
            'appointment_date',
            request('date')
        );
    }


    $appointments = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();


    $doctors = Doctor::with('user')
        ->orderBy('id')
        ->get();

    $departments = Department::orderBy('name')
        ->get();


    return view(
        'admin.appointment.index',
        compact(
            'appointments',
            'doctors',
            'departments'
        )
    );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            //
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
