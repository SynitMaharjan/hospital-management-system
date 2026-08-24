<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
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
        $staff = User::whereIn("role", [
        "doctor",
        "nurse",
        "receptionist",
        ])->latest()->paginate(10);

        return view("admin.staff.index", compact("staff"));
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
    public function show(User $staff)
    {
        return view("admin.staff.show", compact("staff"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $staff)
    {
        return view("admin.staff.edit", compact("staff"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, User $staff)
    {
        $data = $request->validated();

        $staff->update($data);

        return redirect()->route("admin.staff.index")->with("success", "Staff updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route("admin.staff.index")->with("success", "Staff deleted successfully.");
    }
}
