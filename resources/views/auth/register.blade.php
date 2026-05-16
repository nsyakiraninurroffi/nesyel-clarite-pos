@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <div class="text-center mb-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo NESYÈL CLARITÉ" style="width: 80px; height: auto; border-radius: 12px; box-shadow: 0 4px 15px rgba(161, 140, 209, 0.2);">
    </div>
    <div class="brand-text">NESYÈL CLARITÉ</div>
    <div class="text-center text-muted fw-semibold small mb-1">Skincare & Makeup</div>
    <div class="subtitle">Buat Akun Admin Baru</div>

    @if($errors->any())
        <div class="alert alert-danger" style="border-radius: 10px; font-size: 0.85rem;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="position-relative">
                <i class="fa-solid fa-user position-absolute" style="top: 15px; left: 15px; color: #a18cd1;"></i>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" style="padding-left: 45px;" placeholder="Admin Nesyèl" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="position-relative">
                <i class="fa-solid fa-envelope position-absolute" style="top: 15px; left: 15px; color: #a18cd1;"></i>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" style="padding-left: 45px;" placeholder="admin@nesyel.com" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="position-relative">
                <i class="fa-solid fa-lock position-absolute" style="top: 15px; left: 15px; color: #a18cd1;"></i>
                <input type="password" class="form-control" name="password" id="password" style="padding-left: 45px;" placeholder="Minimal 8 karakter" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Ulangi Password</label>
            <div class="position-relative">
                <i class="fa-solid fa-check-double position-absolute" style="top: 15px; left: 15px; color: #a18cd1;"></i>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" style="padding-left: 45px;" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-auth mb-3">Daftar Admin</button>
        
        <div class="text-center" style="font-size: 0.9rem; color: #777;">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link fw-bold">Login</a>
        </div>
    </form>
</div>
@endsection
