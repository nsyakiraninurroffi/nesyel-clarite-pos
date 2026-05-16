@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <div class="text-center mb-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo NESYÈL CLARITÉ" style="width: 80px; height: auto; border-radius: 12px; box-shadow: 0 4px 15px rgba(161, 140, 209, 0.2);">
    </div>
    <div class="brand-text">NESYÈL CLARITÉ</div>
    <div class="text-center text-muted fw-semibold small mb-1">Skincare & Makeup</div>
    <div class="subtitle">Silakan masuk ke akun Admin Anda</div>

    @if($errors->any())
        <div class="alert alert-danger" style="border-radius: 10px; font-size: 0.85rem;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <div class="position-relative">
                <i class="fa-solid fa-envelope position-absolute" style="top: 15px; left: 15px; color: #a18cd1;"></i>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" style="padding-left: 45px;" placeholder="admin@nesyel.com" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="position-relative">
                <i class="fa-solid fa-lock position-absolute" style="top: 15px; left: 15px; color: #a18cd1;"></i>
                <input type="password" class="form-control" name="password" id="password" style="padding-left: 45px;" placeholder="••••••••" required>
            </div>
            <div class="text-end mt-1">
                <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 0.8rem;">Lupa password?</a>
            </div>
        </div>

        <button type="submit" class="btn btn-auth mb-3">Login Sekarang</button>
        
        <div class="text-center" style="font-size: 0.9rem; color: #777;">
            Belum punya akun Admin? <a href="{{ route('register') }}" class="auth-link fw-bold">Daftar</a>
        </div>
    </form>
</div>
@endsection
