@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h2 class="fw-bold text-white mb-0">My Task Center</h2>
            <span class="badge rounded-pill px-3 py-1" style="background: rgba(99, 102, 241, 0.15); color: #a5b4fc; border: 1px solid var(--border-glow); font-size: 0.75rem;">
                {{ $tasks->total() }} Assignments
            </span>
        </div>
        <p class="text-secondary small mb-0">Review task specifications and record operational status updates</p>
    </div>
    <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill d-inline-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Dashboard</span>
    </a>
</div>

<!-- Search & Filter Card -->
<div class="card-panel p-3 mb-4">
    <form action="{{ route('staff.tasks.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-text border-0" style="background: #0f172a; color: #64748b; border: 1.5px solid #334155 !important; border-right: none !important; border-radius: 12px 0 0 12px;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       name="search" 
                       class="form-control form-control-slate border-start-0" 
                       style="border-radius: 0 12px 12px 0;"
                       placeholder="Search assigned tasks by title or keyword..." 
                       value="{{ $search ?? '' }}">
            </div>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-brand w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
            @if(!empty($search))
                <a href="{{ route('staff.tasks.index') }}" class="btn btn-outline-light d-inline-flex align-items-center justify-content-center px-3 rounded-3" title="Clear filter">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Task Table Card -->
<div class="card-panel overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 44%;">Task Specification</th>
                    <th style="width: 18%;">Status Indicator</th>
                    <th style="width: 15%;">Assigned Date</th>
                    <th style="width: 23%;" class="text-end pe-4">Operational Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <!-- Task Title & Description -->
                        <td>
                            <div class="fw-bold text-white fs-6 mb-1">{{ $task->title }}</div>
                            <div class="text-secondary small text-truncate" style="max-width: 440px;">
                                {{ $task->description ?? 'No extra technical notes provided.' }}
                            </div>
                        </td>

                        <!-- Current Status Badge -->
                        <td>
                            @if($task->status === 'Completed')
                                <span class="badge-pill-custom" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Completed</span>
                                </span>
                            @else
                                <span class="badge-pill-custom" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35);">
                                    <i class="bi bi-hourglass-split"></i>
                                    <span>In Progress</span>
                                </span>
                            @endif
                        </td>

                        <!-- Date -->
                        <td class="text-secondary small">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $task->created_at->format('M d, Y') }}
                        </td>

                        <!-- Styled Status Form -->
                        <td class="text-end pe-4">
                            <form action="{{ route('staff.tasks.updateStatus', $task->id) }}" method="POST" class="d-inline-flex align-items-center justify-content-end gap-2">
                                @csrf
                                @method('PATCH')
                                
                                <div class="position-relative">
                                    <select name="status" 
                                            class="form-select form-select-sm text-white fw-semibold rounded-pill ps-3 pe-4 py-1" 
                                            style="background-color: #0f172a; border: 1.5px solid #334155; font-size: 0.825rem; width: 130px; cursor: pointer;">
                                        <option value="Open" {{ $task->status === 'Open' ? 'selected' : '' }} style="background: #151f32; color: #fbbf24;">
                                            Pending
                                        </option>
                                        <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }} style="background: #151f32; color: #34d399;">
                                            Completed
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" 
                                        class="btn btn-brand btn-sm rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm"
                                        title="Apply status change">
                                    <span>Update</span>
                                    <i class="bi bi-arrow-repeat" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-secondary">
                            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle);">
                                <i class="bi bi-clipboard-x fs-2 text-secondary"></i>
                            </div>
                            <h6 class="fw-bold text-white mb-1">No Tasks Found</h6>
                            <p class="small text-secondary mb-0">No assigned tasks match your current query.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($tasks->hasPages())
        <div class="p-3 border-top border-secondary" style="border-color: var(--border-subtle) !important;">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
@endsection