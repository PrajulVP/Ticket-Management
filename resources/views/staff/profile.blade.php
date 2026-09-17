@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center py-3">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card-panel p-4 p-sm-5 position-relative overflow-hidden">
            
            <!-- Top Subtle Glow Accent -->
            <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 130px; height: 130px; background: #6366f1; filter: blur(70px); opacity: 0.35; pointer-events: none;"></div>

            <!-- Profile Header with Initial Avatar -->
            <div class="text-center mb-4 position-relative">
                <div class="d-inline-flex align-items-center justify-content-center text-white mb-3 shadow-lg" style="width: 64px; height: 64px; background: var(--brand-gradient); border-radius: 20px; box-shadow: var(--brand-glow); font-size: 1.5rem; font-weight: 700;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="fw-bold text-white mb-1">Profile Settings</h3>
                <p class="text-secondary small mb-0">Update your public staff credentials and contact line</p>
            </div>

            <form action="{{ route('staff.profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Full Name Field -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light mb-1">Full Name</label>
                    <input type="text" 
                           name="name" 
                           class="form-control form-control-slate @error('name') is-invalid @enderror" 
                           placeholder="Your full name" 
                           value="{{ old('name', $user->name) }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address (Read-Only Pill Design) -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-semibold text-light mb-0">Email Address</label>
                        <span class="badge rounded-pill bg-dark border border-secondary text-secondary" style="font-size: 0.68rem; letter-spacing: 0.04em;">READ-ONLY</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #0f172a; color: #64748b; border: 1.5px solid #334155 !important; border-right: none !important; border-radius: 12px 0 0 12px;">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="email" 
                               class="form-control form-control-slate border-start-0" 
                               style="background: #0f172a; color: #94a3b8 !important; cursor: not-allowed; border-radius: 0 12px 12px 0;" 
                               value="{{ $user->email }}" 
                               disabled 
                               readonly>
                    </div>
                    <small class="text-secondary d-block mt-1" style="font-size: 0.725rem;">Contact your administrator if you need to alter your login email.</small>
                </div>

                <!-- Phone Number Field -->
                <div class="mb-4">
                    <label class="form-label small fw-semibold text-light mb-1">Direct Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #0f172a; color: #64748b; border: 1.5px solid #334155 !important; border-right: none !important; border-radius: 12px 0 0 12px;">
                            <i class="bi bi-telephone"></i>
                        </span>
                        <input type="text" 
                               name="phone" 
                               class="form-control form-control-slate border-start-0 @error('phone') is-invalid @enderror" 
                               style="border-radius: 0 12px 12px 0;"
                               placeholder="10-digit number (e.g. 9876543210)" 
                               maxlength="10"
                               pattern="[0-9]{10}"
                               inputmode="numeric"
                               value="{{ old('phone', $user->phone) }}"
                               required>
                    </div>
                    @error('phone')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Button -->
                <button type="submit" class="btn btn-brand w-100 py-2 fs-6 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-check2-circle fs-5"></i>
                    <span>Save Profile Changes</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection