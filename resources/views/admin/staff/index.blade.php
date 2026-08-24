@extends("layouts.app")

@section("content")

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>Staff Management</h1>
            <p class="text-muted mb-0">
                Manage hospital staff accounts.
            </p>
        </div>

        <a href="{{ route("admin.staff.create") }}"
           class="btn btn-success">
            Create Staff Account
        </a>

    </div>

    @if(session("success"))
        <div class="alert alert-success">
            {{ session("success") }}
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($staff as $member)

                            <tr>

                                <td>
                                    {{ $member->name }}
                                </td>

                                <td>
                                    {{ $member->email }}
                                </td>

                                <td>
                                    {{ ucfirst($member->role) }}
                                </td>

                                <td>
                                    {{ $member->created_at->format("M d, Y") }}
                                </td>

                                <td>

                                    <a href="{{ route("admin.staff.show", $member) }}"
                                       class="btn btn-sm btn-primary">
                                        View
                                    </a>

                                    <a href="{{ route("admin.staff.edit", $member) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route("admin.staff.destroy", $member) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method("DELETE")

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this staff account?')">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    No staff accounts found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $staff->links() }}

        </div>

    </div>

</div>

@endsection