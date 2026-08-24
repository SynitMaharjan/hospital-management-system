<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        $data = $request->validated();
        $temporaryPassword = Str::password(12);

        $staff = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($temporaryPassword),
            "role" => $data['role'],
            "must_change_password" => true,
        ]);

        return view("admin.staff.created", [
            "staff" => $staff,
            "temporaryPassword" => $temporaryPassword,
        ]);
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
