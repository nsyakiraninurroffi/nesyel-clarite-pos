@extends('layouts.app')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 fw-bold brand-font" style="color: var(--text-color)"><i class="fa-solid fa-user-circle me-2" style="color: var(--accent-purple)"></i> Profile Admin</h3>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-custom rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card summary-card shadow-sm border-0" style="border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                        <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple)); color: white; font-size: 2.5rem; font-weight: bold; box-shadow: 0 5px 15px rgba(161, 140, 209, 0.4);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5 class="mt-3 fw-bold">{{ $user->name }}</h5>
                        <p class="text-muted small">Administrator</p>
                    </div>
                
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4" style="border-color: var(--border-color);">
                    <h6 class="fw-bold mb-3" style="color: var(--text-color);">Ganti Password <span class="text-muted small fw-normal">(opsional)</span></h6>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin ganti">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom btn-lg">
                            <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
