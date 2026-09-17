@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-white mb-1">Staff Management</h2>
        <p class="text-secondary small mb-0">Create new staff accounts, modify profiles, and manage system access</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

<div class="row g-4">
    <!-- Add Staff Form -->
    <div class="col-lg-4">
        <div class="card-panel p-4 position-relative">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="p-2 rounded-3" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                    <i class="bi bi-person-plus-fill fs-5"></i>
                </div>
                <h5 class="fw-bold text-white mb-0">Add New Staff</h5>
            </div>

            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light mb-1">Full Name</label>
                    <input type="text" 
                           name="name" 
                           class="form-control form-control-slate @error('name') is-invalid @enderror" 
                           placeholder="Full name" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light mb-1">Email Address</label>
                    <input type="email" 
                           name="email" 
                           class="form-control form-control-slate @error('email') is-invalid @enderror" 
                           placeholder="staff@company.com" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light mb-1">Contact Phone</label>
                    <input type="text" 
                           name="phone" 
                           class="form-control form-control-slate @error('phone') is-invalid @enderror" 
                           placeholder="10-digit number (e.g. 9876543210)" 
                           maxlength="10"
                           pattern="[0-9]{10}"
                           inputmode="numeric"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light mb-1">Account Password</label>
                    <input type="password" 
                           name="password" 
                           class="form-control form-control-slate @error('password') is-invalid @enderror" 
                           placeholder="Minimum 8 characters" 
                           required>
                    @error('password')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold text-light mb-1">Initial Status</label>
                    <select name="status" class="form-select form-select-slate" required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-brand w-100 py-2 fs-6">
                    <i class="bi bi-person-check me-1"></i> Register Staff
                </button>
            </form>
        </div>
    </div>

    <!-- Staff Directory List -->
    <div class="col-lg-8">
        <div class="card-panel overflow-hidden">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--border-subtle) !important;">
                <div>
                    <h5 class="fw-bold text-white mb-0">Staff Directory</h5>
                    <span class="text-secondary small">Total records: {{ $staffs->total() }}</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Contact Info</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffs as $staff)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle fw-bold d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; background: #334155;">
                                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-white">{{ $staff->name }}</div>
                                            <div class="small text-secondary">Added {{ $staff->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-light small">{{ $staff->email }}</div>
                                    <div class="text-secondary small">{{ $staff->phone ?? 'No phone' }}</div>
                                </td>
                                <td>
                                    @if($staff->status === 'active')
                                        <span class="badge-pill-custom" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                                            <i class="bi bi-dot fs-5"></i> Active
                                        </span>
                                    @else
                                        <span class="badge-pill-custom" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">
                                            <i class="bi bi-dot fs-5"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-light rounded-pill px-3 me-1" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $staff->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Soft-delete this staff member?');">
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
                                    <i class="bi bi-people fs-2 d-block mb-2"></i>
                                    No staff accounts configured in the system.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($staffs->hasPages())
                <div class="p-3 border-top border-secondary">
                    {{ $staffs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Staff Modals -->
@foreach($staffs as $staff)
    <div class="modal fade" id="editStaffModal{{ $staff->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #151f32; color: #fff; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 18px;">
                <div class="modal-header border-secondary pb-3">
                    <h5 class="modal-title text-white fw-bold">Edit Staff &bull; {{ $staff->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-slate" value="{{ $staff->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-slate" value="{{ $staff->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Phone Number</label>
                            <input type="text" 
                                   name="phone" 
                                   class="form-control form-control-slate" 
                                   value="{{ $staff->phone }}" 
                                   placeholder="10-digit number" 
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   inputmode="numeric">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Account Status</label>
                            <select name="status" class="form-select form-select-slate">
                                <option value="active" {{ $staff->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $staff->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-secondary">Change Password (Leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control form-control-slate" placeholder="Minimum 8 characters">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary pt-2">
                        <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-brand btn-sm rounded-pill px-4">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection