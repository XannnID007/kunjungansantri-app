@extends('layouts.app')

@section('title', 'Tambah Kunjungan')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / <a href="{{ route('admin.kunjungan.index') }}">Data Kunjungan</a> /</span>
        Tambah Kunjungan
    </h4>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <h5 class="card-header">Form Tambah Kunjungan</h5>
                <div class="card-body">
                    <form action="{{ route('admin.kunjungan.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="santri_id" class="form-label">Santri</label>
                                <select class="form-select @error('santri_id') is-invalid @enderror" id="santri_id"
                                    name="santri_id" required>
                                    <option value="">-- Pilih Santri --</option>
                                    @foreach ($santri as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('santri_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }} ({{ $s->kamar }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('santri_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="wali_id" class="form-label">Wali Santri</label>
                                <select class="form-select @error('wali_id') is-invalid @enderror" id="wali_id"
                                    name="wali_id" required>
                                    <option value="">-- Pilih Wali Santri --</option>
                                    @foreach ($wali as $w)
                                        <option value="{{ $w->id }}"
                                            {{ old('wali_id') == $w->id ? 'selected' : '' }}>
                                            {{ $w->nama }} ({{ $w->hubungan }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('wali_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                                    id="tanggal_kunjungan" name="tanggal_kunjungan"
                                    value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required>
                                @error('tanggal_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jam_kunjungan" class="form-label">Jam Kunjungan</label>
                                <input type="time" class="form-control @error('jam_kunjungan') is-invalid @enderror"
                                    id="jam_kunjungan" name="jam_kunjungan" value="{{ old('jam_kunjungan') }}" required>
                                @error('jam_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan_kunjungan" class="form-label">Tujuan Kunjungan</label>
                            <input type="text" class="form-control @error('tujuan_kunjungan') is-invalid @enderror"
                                id="tujuan_kunjungan" name="tujuan_kunjungan" value="{{ old('tujuan_kunjungan') }}"
                                required>
                            @error('tujuan_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="checked_in" {{ old('status') == 'checked_in' ? 'selected' : '' }}>Checked In
                                </option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Panduan</h5>
                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="bx bx-info-circle me-1"></i>
                            Informasi Penting
                        </h6>
                        <p class="mb-0">Tambah kunjungan digunakan oleh admin untuk mendaftarkan kunjungan secara manual.
                        </p>
                    </div>

                    <h6 class="mt-4">Panduan Pengisian:</h6>
                    <ul>
                        <li>Pilih santri yang akan dikunjungi</li>
                        <li>Pilih wali santri yang melakukan kunjungan</li>
                        <li>Tentukan tanggal dan jam kunjungan</li>
                        <li>Isi tujuan kunjungan</li>
                        <li>Pilih status kunjungan sesuai kebutuhan</li>
                    </ul>

                    <div class="alert alert-warning mt-3" role="alert">
                        <h6 class="alert-heading fw-bold mb-1">
                            <i class="bx bx-error me-1"></i>
                            Catatan
                        </h6>
                        <p class="mb-0">Pastikan tanggal dan jam kunjungan sesuai dengan jadwal operasional yang tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
