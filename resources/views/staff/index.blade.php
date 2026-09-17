@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-white">Staff Management</h3>
        <p class="text-secondary small mb-0">Create, monitor, and remove staff team members</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

<div class="row g-4">
    <!-- Add Staff Form -->
    <div class="col-lg-4">
        <div class="card card-dark p-4">
            <h5 class="fw-bold text-white mb-3">Add New Staff</h5>
            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Full Name</label>
                    <input type="text" name="name" class="form-control form-control-dark" placeholder="e.g. Alex Morgan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-dark" placeholder="alex@company.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold text-secondary">Initial Password</label>
                    <input type="password" name="password" class="form-control form-control-dark" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-brand w-100 py-2">
                    <i class="bi bi-person-plus-fill me-1"></i> Register Staff
                </button>
            </form>
        </div>
    </div>

    <!-- Staff List -->
    <div class="col-lg-8">
        <div class="card card-dark overflow-hidden">
            <div class="p-3 px-4 border-bottom" style="border-color: var(--dark-border) !important;">
                <h5 class="fw-bold mb-0 text-white">Existing Staff Members</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Email</th>
                            <th>Created On</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffs as $staff)
                            <tr>
                                <td>
                                    <div class="fw-bold text-white">{{ $staff->name }}</div>
                                </td>
                                <td class="text-secondary">{{ $staff->email }}</td>
                                <td class="text-secondary small">{{ $staff->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Remove this staff member?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary">
                                    No staff accounts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($staffs, 'links'))
                <div class="p-3">
                    {{ $staffs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection