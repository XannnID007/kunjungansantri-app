@extends('layouts.app')

@section('title', 'Tambah Jadwal Operasional')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / <a href="{{ route('admin.jadwal.index') }}">Jadwal Operasional</a> /</span>
        Tambah Jadwal
    </h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Form Tambah Jadwal</h5>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select class="form-select @error('hari') is-invalid @enderror" id="hari" name="hari"
                                required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach ($hari as $h)
                                    <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>
                                        {{ $h }}</option>
                                @endforeach
                            </select>
                            @error('hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="jam_buka" class="form-label">Jam Buka</label>
                                <input type="time" class="form-control @error('jam_buka') is-invalid @enderror"
                                    id="jam_buka" name="jam_buka" value="{{ old('jam_buka') }}" required>
                                @error('jam_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jam_tutup" class="form-label">Jam Tutup</label>
                                <input type="time" class="form-control @error('jam_tutup') is-invalid @enderror"
                                    id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup') }}" required>
                                @error('jam_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kuota_kunjungan" class="form-label">Kuota Kunjungan</label>
                            <input type="number" class="form-control @error('kuota_kunjungan') is-invalid @enderror"
                                id="kuota_kunjungan" name="kuota_kunjungan" value="{{ old('kuota_kunjungan', 0) }}"
                                min="0" required>
                            @error('kuota_kunjungan')
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
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label" for="is_active">Jadwal Aktif</label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Panduan Jadwal Operasional</h5>
                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                        <div class="alert-body">
                            <p class="mb-0">
                                <i class="bx bx-info-circle me-1"></i>
                                Jadwal operasional digunakan untuk mengatur ketersediaan waktu kunjungan santri.
                            </p>
                        </div>
                    </div>
                    <h6>Petunjuk Pengisian:</h6>
                    <ul class="ps-3 mb-0">
                        <li>Pilih hari untuk jadwal kunjungan</li>
                        <li>Tentukan jam buka dan jam tutup</li>
                        <li>Tentukan kuota kunjungan (jumlah maksimal kunjungan yang diperbolehkan pada jadwal tersebut)
                        </li>
                        <li>Berikan catatan tambahan jika diperlukan (opsional)</li>
                        <li>Aktifkan atau nonaktifkan jadwal sesuai kebutuhan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
