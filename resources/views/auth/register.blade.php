@extends('layouts.auth')

@section('title', 'Register')
@section('auth-subtitle', 'Buat akun baru Anda')

@section('content')
    <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required autofocus />
            @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Masukkan email Anda" value="{{ old('email') }}" required />
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="••••••••••••"
                    aria-describedby="password" required />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    placeholder="••••••••••••" aria-describedby="password_confirmation" required />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>

        {{-- Submit --}}
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">
                Register
            </button>
        </div>
    </form>

    <p class="text-center">
        <span>Sudah punya akun?</span>
        <a href="{{ route('login') }}">
            <span>Login di sini</span>
        </a>
    </p>
@endsection
