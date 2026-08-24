@extends("layouts.app")

@section("content")

<h1>Change Your Password</h1>

<p>
    You are using a temporary password.
    Please create a new password before continuing.
</p>

<form action="{{ route("password.update") }}" method="POST">

    @csrf

    <div>
        <label for="password">New Password</label>

        <input
            type="password"
            id="password"
            name="password"
        >

        @error("password")
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation">
            Confirm New Password
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
        >
    </div>

    <button type="submit">
        Change Password
    </button>

</form>

@endsection