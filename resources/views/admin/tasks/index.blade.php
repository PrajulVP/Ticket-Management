@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h2 class="fw-bold text-white mb-0">Task Management</h2>
            <span class="badge rounded-pill px-3 py-1" style="background: rgba(99, 102, 241, 0.15); color: #a5b4fc; border: 1px solid var(--border-glow); font-size: 0.75rem;">
                {{ $tasks->total() }} Total Tasks
            </span>
        </div>
        <p class="text-secondary small mb-0">Create, assign, edit, and monitor system support tickets</p>
    </div>
    <button class="btn btn-brand px-4 py-2 d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createTaskModal">
        <i class="bi bi-plus-circle-fill fs-5"></i>
        <span>Create New Task</span>
    </button>
</div>

<!-- Search & Filter Bar -->
<div class="card-panel p-3 mb-4">
    <form action="{{ route('admin.tasks.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-text border-0" style="background: #0f172a; color: #64748b; border: 1.5px solid #334155 !important; border-right: none !important; border-radius: 12px 0 0 12px;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       name="search" 
                       class="form-control form-control-slate border-start-0" 
                       style="border-radius: 0 12px 12px 0;"
                       placeholder="Search tasks by title or keyword..." 
                       value="{{ $search ?? '' }}">
            </div>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-brand w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-funnel-fill"></i>
                <span>Search</span>
            </button>
            @if(!empty($search))
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-light d-inline-flex align-items-center justify-content-center px-3 rounded-3" title="Clear search">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tasks Data Card -->
<div class="card-panel overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 38%;">Task Details</th>
                    <th style="width: 18%;">Assigned Staff</th>
                    <th style="width: 14%;">Status</th>
                    <th style="width: 14%;">Created Date</th>
                    <th style="width: 16%;" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>
                            <div class="fw-bold text-white fs-6 mb-1">{{ $task->title }}</div>
                            <div class="text-secondary small text-truncate" style="max-width: 400px;">
                                {{ $task->description ?? 'No additional description provided.' }}
                            </div>
                        </td>
                        <td>
                            @if($task->assignedStaff)
                                <span class="badge-pill-custom" style="background: rgba(99, 102, 241, 0.15); color: #c7d2fe; border: 1px solid var(--border-glow);">
                                    <i class="bi bi-person-fill"></i> {{ $task->assignedStaff->name }}
                                </span>
                            @else
                                <span class="badge-pill-custom" style="background: rgba(148, 163, 184, 0.1); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2);">
                                    <i class="bi bi-person-dash"></i> Unassigned
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($task->status === 'Completed')
                                <span class="badge-pill-custom" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);">
                                    <i class="bi bi-check-circle-fill"></i> Completed
                                </span>
                            @else
                                <span class="badge-pill-custom" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35);">
                                    <i class="bi bi-hourglass-split"></i> Open
                                </span>
                            @endif
                        </td>
                        <td class="text-secondary small">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $task->created_at->format('M d, Y') }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-2">
                                <button class="btn btn-sm rounded-pill px-3 py-1 text-white d-inline-flex align-items-center gap-1"
                                        style="background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-subtle);"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editTaskModal{{ $task->id }}">
                                    <i class="bi bi-pencil-square text-primary"></i> Edit
                                </button>
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Soft-delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1"
                                            style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-secondary">
                            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle);">
                                <i class="bi bi-card-checklist fs-2 text-secondary"></i>
                            </div>
                            <h6 class="fw-bold text-white mb-1">No Tasks Found</h6>
                            <p class="small text-secondary mb-0">No records match your search criteria.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tasks->hasPages())
        <div class="p-3 border-top border-secondary" style="border-color: var(--border-subtle) !important;">
            {{ $tasks->links() }}
        </div>
    @endif
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #151f32; color: #fff; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 18px;">
            <div class="modal-header border-secondary pb-3">
                <h5 class="modal-title text-white fw-bold">Create New Task</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-light mb-1">Task Title</label>
                        <input type="text" name="title" class="form-control form-control-slate" placeholder="e.g. Upgrade Database Schema" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-light mb-1">Task Description</label>
                        <textarea name="description" class="form-control form-control-slate" rows="3" placeholder="Provide detailed technical instructions..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-light mb-1">Assign to Active Staff</label>
                        <select name="assigned_to" class="form-select form-select-slate">
                            <option value="">-- Leave Unassigned --</option>
                            @foreach($activeStaffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-light mb-1">Initial Status</label>
                        <select name="status" class="form-select form-select-slate">
                            <option value="Open">Open</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary pt-2">
                    <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-brand btn-sm rounded-pill px-4">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modals (Safely isolated outside table tags) -->
@foreach($tasks as $task)
    <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #151f32; color: #fff; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 18px;">
                <div class="modal-header border-secondary pb-3">
                    <h5 class="modal-title text-white fw-bold">Edit Task &bull; #{{ $task->id }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-light mb-1">Task Title</label>
                            <input type="text" name="title" class="form-control form-control-slate" value="{{ $task->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-light mb-1">Task Description</label>
                            <textarea name="description" class="form-control form-control-slate" rows="3">{{ $task->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-light mb-1">Assigned Staff</label>
                            <select name="assigned_to" class="form-select form-select-slate">
                                <option value="">-- Unassigned --</option>
                                @foreach($activeStaffs as $staff)
                                    <option value="{{ $staff->id }}" {{ $task->assigned_to === $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }} ({{ $staff->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-light mb-1">Operational Status</label>
                            <select name="status" class="form-select form-select-slate">
                                <option value="Open" {{ $task->status === 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary pt-2">
                        <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand btn-sm rounded-pill px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection