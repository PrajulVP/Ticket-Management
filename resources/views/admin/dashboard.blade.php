@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-white mb-1">Executive Dashboard</h2>
        <p class="text-secondary small mb-0">Live workload distribution and staff resolution analytics</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-brand px-3 py-2 btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Manage Tasks
        </a>
    </div>
</div>

<!-- 4 Key Stat Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat stat-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-bold text-uppercase tracking-wider">Total Staff</span>
                    <h2 class="fw-bold text-white mt-2 mb-0">{{ $totalStaff }}</h2>
                </div>
                <div class="p-3 rounded-4" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat stat-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-bold text-uppercase tracking-wider">Total Tasks</span>
                    <h2 class="fw-bold text-white mt-2 mb-0">{{ $totalTasks }}</h2>
                </div>
                <div class="p-3 rounded-4" style="background: rgba(6, 182, 212, 0.15); color: #22d3ee;">
                    <i class="bi bi-kanban-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat stat-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-bold text-uppercase tracking-wider">Pending / Open</span>
                    <h2 class="fw-bold text-white mt-2 mb-0" style="color: #fbbf24;">{{ $openTasks }}</h2>
                </div>
                <div class="p-3 rounded-4" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                    <i class="bi bi-hourglass-split fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat stat-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-bold text-uppercase tracking-wider">Resolved</span>
                    <h2 class="fw-bold text-white mt-2 mb-0" style="color: #34d399;">{{ $closedTasks }}</h2>
                </div>
                <div class="p-3 rounded-4" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                    <i class="bi bi-check-circle-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Performers Section -->
<div class="card-panel overflow-hidden">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--border-subtle) !important;">
        <div>
            <h5 class="fw-bold text-white mb-1">Top Performing Active Staff</h5>
            <p class="text-secondary small mb-0">Ranked by volume of completed tasks</p>
        </div>
        <span class="badge-pill-custom" style="background: rgba(99, 102, 241, 0.15); color: #c7d2fe; border: 1px solid var(--border-glow);">
            <i class="bi bi-trophy-fill text-warning"></i> Leaderboard
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Contact Email</th>
                    <th>Direct Phone</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Resolved Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topPerformers as $index => $staff)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle fw-bold d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background: {{ ['#4f46e5', '#0284c7', '#059669', '#d97706', '#64748b'][$index] ?? '#64748b' }};">
                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-white">{{ $staff->name }}</div>
                                    <div class="small text-secondary">Rank #{{ $index + 1 }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-light">{{ $staff->email }}</td>
                        <td class="text-secondary">{{ $staff->phone ?? 'Not set' }}</td>
                        <td>
                            <span class="badge-pill-custom" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                                <i class="bi bi-dot fs-5"></i> Active
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <span class="badge-pill-custom" style="background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid var(--border-glow);">
                                <i class="bi bi-check2-all"></i> {{ $staff->completed_count }} Completed
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-secondary">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            No staff resolution activity recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection