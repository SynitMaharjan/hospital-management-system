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

                $q->where('phone', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {

                        $q->where('name', 'ilike', "%{$search}%")
                            ->orWhere('username', 'ilike', "%{$search}%")
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

        $patients = $query
            ->latest()
            ->paginate(10);

        $patients->appends(request()->query());

        return view(
            'admin.patient.index',
            compact('patients')
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
