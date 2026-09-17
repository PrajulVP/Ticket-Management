@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
        <div class="card-panel p-4 p-sm-5 position-relative overflow-hidden" style="background: #151f32; border: 1.5px solid rgba(255, 255, 255, 0.1);">
            
            <!-- Glow Accent -->
            <div style="position: absolute; top: -60px; left: 50%; transform: translateX(-50%); width: 140px; height: 140px; background: #6366f1; filter: blur(75px); opacity: 0.45; pointer-events: none;"></div>

            <div class="text-center mb-4 position-relative">
                <div class="d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 60px; height: 60px; background: var(--brand-gradient); border-radius: 18px; box-shadow: var(--brand-glow);">
                    <i class="bi bi-shield-lock-fill fs-3"></i>
                </div>
                <h3 class="fw-bold text-white mb-1">TicketDesk</h3>
                <p class="text-secondary small mb-0">Authorized Personnel Sign In</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light mb-1">Email Address</label>
                    <input type="email" 
                           name="email" 
                           class="form-control form-control-slate @error('email') is-invalid @enderror" 
                           placeholder="name@company.com" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold text-light mb-1">Password</label>
                    <input type="password" 
                           name="password" 
                           class="form-control form-control-slate @error('password') is-invalid @enderror" 
                           placeholder="Minimum 8 characters" 
                           required>
                    @error('password')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-brand w-100 py-3 fs-6">
                    Sign In <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection