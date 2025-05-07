@extends('layouts.app')

@section('title', 'Edit Jadwal Operasional')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / <a href="{{ route('admin.jadwal.index') }}">Jadwal Operasional</a> /</span>
        Edit Jadwal
    </h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Form Edit Jadwal</h5>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select class="form-select @error('hari') is-invalid @enderror" id="hari" name="hari"
                                required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach ($hari as $h)
                                    <option value="{{ $h }}"
                                        {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ $h }}
                                    </option>
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
                                    id="jam_buka" name="jam_buka"
                                    value="{{ old('jam_buka', \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i')) }}"
                                    required>
                                @error('jam_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jam_tutup" class="form-label">Jam Tutup</label>
                                <input type="time" class="form-control @error('jam_tutup') is-invalid @enderror"
                                    id="jam_tutup" name="jam_tutup"
                                    value="{{ old('jam_tutup', \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i')) }}"
                                    required>
                                @error('jam_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kuota_kunjungan" class="form-label">Kuota Kunjungan</label>
                            <input type="number" class="form-control @error('kuota_kunjungan') is-invalid @enderror"
                                id="kuota_kunjungan" name="kuota_kunjungan"
                                value="{{ old('kuota_kunjungan', $jadwal->kuota_kunjungan) }}" min="0" required>
                            @error('kuota_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $jadwal->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $jadwal->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Jadwal Aktif</label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Status Jadwal Operasional</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm flex-shrink-0 me-3">
                            <span
                                class="avatar-initial rounded-circle bg-label-{{ $jadwal->is_active ? 'success' : 'danger' }}">
                                <i class="bx bx-{{ $jadwal->is_active ? 'check' : 'x' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0">Status: {{ $jadwal->is_active ? 'Aktif' : 'Tidak Aktif' }}</h6>
                            <small class="text-muted">Jadwal ini
                                {{ $jadwal->is_active ? 'sedang aktif dan dapat dipilih oleh wali santri' : 'tidak aktif dan tidak akan ditampilkan pada pilihan jadwal' }}</small>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info mt-3" role="alert">
                        <div class="alert-body">
                            <h6 class="alert-heading mb-1"><i class="bx bx-info-circle me-1"></i> Informasi Jadwal</h6>
                            <p class="mb-0">Anda dapat mengubah status jadwal menjadi aktif atau tidak aktif kapan saja
                                sesuai kebutuhan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
