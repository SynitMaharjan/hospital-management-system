@extends('layouts.app')
@section('content')
<h1>Staff Account Created</h1>

<p>
    Staff account has been successfully created.
</p>

<p>
    <strong>Name:</strong> {{ $staff->name }}
</p>

<p>
    <strong>Email:</strong> {{ $staff->email }}
</p>

<p>
    <strong>Role:</strong> {{ $staff->role->value }}
</p>

<p>
    <strong>Temporary Password:</strong>
    {{ $temporaryPassword }}
</p>

<p>
    Give these credentials to the staff member.
</p>

<a href="{{ route("admin.staff.create") }}">
    Create Another Staff Account
</a>
@endsection