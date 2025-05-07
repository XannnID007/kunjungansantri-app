@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Buat Akun Wali Santri</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.wali-santri.store-account') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="wali_santri_id">Wali Santri</label>
                                <select name="wali_santri_id" id="wali_santri_id"
                                    class="form-control @error('wali_santri_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Wali Santri --</option>
                                    @foreach ($waliSantri as $wali)
                                        <option value="{{ $wali->id }}"
                                            {{ old('wali_santri_id') == $wali->id ? 'selected' : '' }}>
                                            {{ $wali->nama }} - {{ $wali->no_hp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('wali_santri_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Buat Akun</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
