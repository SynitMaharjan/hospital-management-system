@extends("layouts.dashboard")

@section("page-title")
    Audit Logs
@endsection

@section("dashboard-content")

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="fw-semibold mb-1">
            Audit Logs
        </h4>

        <p class="text-muted mb-0">
            Track important actions performed in the hospital system.
        </p>
    </div>

    <a href="{{ route("admin.dashboard") }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Dashboard
    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h6 class="fw-semibold mb-0">
                Activity History
            </h6>

            <span class="text-muted small">
                {{ $auditLogs->total() }} total activities
            </span>

        </div>

    </div>


    <div class="card-body p-0">

        @forelse($auditLogs as $log)

            <div class="d-flex justify-content-between align-items-center
                        px-4 py-3 border-top">

                <div>

                    <div class="fw-semibold">
                        {{ $log->description }}
                    </div>

                    <div class="small text-muted mt-1">

                        By
                        <span class="fw-medium">
                            {{ $log->user?->name ?? "System" }}
                        </span>

                        ·

                        {{ $log->created_at->format("M d, Y h:i A") }}

                    </div>

                </div>


                <div>

                    @if($log->action === "created")

                        <span class="badge text-bg-success">
                            Created
                        </span>

                    @elseif($log->action === "updated")

                        <span class="badge text-bg-primary">
                            Updated
                        </span>

                    @elseif($log->action === "deleted")

                        <span class="badge text-bg-danger">
                            Deleted
                        </span>

                    @else

                        <span class="badge text-bg-secondary">
                            {{ ucfirst($log->action) }}
                        </span>

                    @endif

                </div>

            </div>

        @empty

            <div class="text-center text-muted py-5">

                <i class="fa-solid fa-clock-rotate-left fa-2x mb-3"></i>

                <p class="mb-0">
                    No audit activity found.
                </p>

            </div>

        @endforelse

    </div>


    @if($auditLogs->hasPages())

        <div class="card-footer bg-white border-0 p-3">

            {{ $auditLogs->links() }}

        </div>

    @endif

</div>

@endsection