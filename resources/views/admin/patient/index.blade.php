@extends('layouts.dashboard')

@section('dashboard-content')
<div class="container">
    <h1>Patients</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->phone }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection