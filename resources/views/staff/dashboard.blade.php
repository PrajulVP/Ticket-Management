@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-white mb-1">Hello, {{ auth()->user()->name }}</h2>
        <p class="text-secondary small mb-0">Welcome back. Here is your real-time assignment summary.</p>
    </div>
    <a href="{{ route('staff.tasks.index') }}" class="btn btn-brand px-4 py-2 d-inline-flex align-items-center gap-2">
        <i class="bi bi-arrow-right-circle-fill fs-5"></i>
        <span>Go to My Assigned Tasks</span>
    </a>
</div>

<!-- Key Stat Metric Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-stat stat-primary">
            <span class="text-secondary small fw-bold text-uppercase tracking-wider">Total Tasks Assigned</span>
            <h1 class="fw-bold text-white mt-2 mb-0">{{ $totalAssigned }}</h1>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat stat-warning">
            <span class="text-secondary small fw-bold text-uppercase tracking-wider">Pending / In Progress</span>
            <h1 class="fw-bold mt-2 mb-0" style="color: #fbbf24;">{{ $openTasks }}</h1>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-stat stat-success">
            <span class="text-secondary small fw-bold text-uppercase tracking-wider">Completed by You</span>
            <h1 class="fw-bold mt-2 mb-0" style="color: #34d399;">{{ $completedTasks }}</h1>
        </div>
    </div>
</div>

<!-- Read-Only Overview List (Zero form interaction) -->
<div class="card-panel overflow-hidden">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--border-subtle) !important;">
        <div>
            <h5 class="fw-bold text-white mb-1">Recent Assignment Overview</h5>
            <p class="text-secondary small mb-0">To change task progress status, please use the dedicated task center.</p>
        </div>
        <a href="{{ route('staff.tasks.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
            Open Task Center <i class="bi bi-chevron-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th style="width: 50%;">Task Title & Details</th>
                    <th>Current Status</th>
                    <th class="text-end pe-4">Assigned Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTasks as $task)
                    <tr>
                        <td>
                            <div class="fw-bold text-white fs-6 mb-1">{{ $task->title }}</div>
                            <div class="text-secondary small text-truncate" style="max-width: 450px;">
                                {{ $task->description ?? 'No details provided.' }}
                            </div>
                        </td>
                        <td>
                            @if($task->status === 'Completed')
                                <span class="badge-pill-custom" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="bi bi-check-circle-fill"></i> Completed
                                </span>
                            @else
                                <span class="badge-pill-custom" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">
                                    <i class="bi bi-hourglass-split"></i> Open
                                </span>
                            @endif
                        </td>
                        <td class="text-secondary small text-end pe-4">
                            {{ $task->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-secondary">
                            <i class="bi bi-clipboard2-check fs-2 d-block mb-2"></i>
                            No tasks currently assigned to you.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection