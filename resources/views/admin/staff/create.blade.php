@extends('layouts.app')

@section('content')
<h1>Create Staff Account</h1>

<form action="{{ route("admin.staff.store") }}" method="POST">

    @csrf

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old("name") }}">
        @error("name")
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Username</label>
        <input type="text" name="username" value="{{ old("username") }}">
        @error("username")
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Employee ID</label>
        <input type="text" name="employee_id" value="{{ old("employee_id") }}">
        @error("employee_id")
            <p>{{ $message }}</p>
        @enderror

    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old("email") }}">
        @error("email")
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>Role</label>

        <select name="role">
            <option value="">Select Role</option>
            <option value="doctor">Doctor</option>
            <option value="nurse">Nurse</option>
            <option value="receptionist">Receptionist</option>
            
        </select>

        @error("role")
            <p>{{ $message }}</p>
        @enderror
    </div>

    <button type="submit">
        Create Staff Account
    </button>

</form>
@endsection 