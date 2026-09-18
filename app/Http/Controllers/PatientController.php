<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Patient::with('user');

        // Search
        if (request('search')) {

            $search = request('search');

            $query->where(function ($q) use ($search) {

                $q->where('patient_number', 'ilike', "%{$search}%")
                    ->orWhere('first_name', 'ilike', "%{$search}%")
                    ->orWhere('last_name', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {

                        $q->where('username', 'ilike', "%{$search}%")
                            ->orWhere('email', 'ilike', "%{$search}%");

                    });

            });
        }

        // Gender filter
        if (request('gender')) {

            $query->where(
                'gender',
                request('gender')
            );
        }

        // Blood group filter
        if (request('blood_group')) {

            $query->where(
                'blood_group',
                request('blood_group')
            );
        }

        $patients = $query
            ->latest()
            ->paginate(10);

        $patients->appends(request()->query());

        return view(
            'admin.patient.index',
            compact('patients')
        );
    }
}