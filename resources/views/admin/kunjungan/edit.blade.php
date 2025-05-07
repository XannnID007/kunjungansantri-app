@extends('layouts.app')

@section('title', 'Edit Kunjungan')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / <a href="{{ route('admin.kunjungan.index') }}">Data Kunjungan</a> /</span>
        Edit Kunjungan
    </h4>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <h5 class="card-header">Form Edit Kunjungan</h5>
                <div class="card-body">
                    <form action="{{ route('admin.kunjungan.update', $kunjungan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                                    id="tanggal_kunjungan" name="tanggal_kunjungan"
                                    value="{{ old('tanggal_kunjungan', $kunjungan->tanggal_kunjungan->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jam_kunjungan" class="form-label">Jam Kunjungan</label>
                                <input type="time" class="form-control @error('jam_kunjungan') is-invalid @enderror"
                                    id="jam_kunjungan" name="jam_kunjungan"
                                    value="{{ old('jam_kunjungan', \Carbon\Carbon::parse($kunjungan->jam_kunjungan)->format('H:i')) }}"
                                    required>
                                @error('jam_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan_kunjungan" class="form-label">Tujuan Kunjungan</label>
                            <input type="text" class="form-control @error('tujuan_kunjungan') is-invalid @enderror"
                                id="tujuan_kunjungan" name="tujuan_kunjungan"
                                value="{{ old('tujuan_kunjungan', $kunjungan->tujuan_kunjungan) }}" required>
                            @error('tujuan_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $kunjungan->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="pending"
                                    {{ old('status', $kunjungan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed"
                                    {{ old('status', $kunjungan->status) == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="checked_in"
                                    {{ old('status', $kunjungan->status) == 'checked_in' ? 'selected' : '' }}>Checked In
                                </option>
                                <option value="in_progress"
                                    {{ old('status', $kunjungan->status) == 'in_progress' ? 'selected' : '' }}>In Progress
                                </option>
                                <option value="completed"
                                    {{ old('status', $kunjungan->status) == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled"
                                    {{ old('status', $kunjungan->status) == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header">Informasi Kunjungan</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div
                            class="badge bg-label-{{ $kunjungan->status == 'pending'
                                ? 'warning'
                                : ($kunjungan->status == 'confirmed'
                                    ? 'info'
                                    : ($kunjungan->status == 'checked_in'
                                        ? 'primary'
                                        : ($kunjungan->status == 'in_progress'
                                            ? 'success'
                                            : ($kunjungan->status == 'completed'
                                                ? 'secondary'
                                                : 'danger')))) }} me-2">
                            {{ ucfirst($kunjungan->status) }}
                        </div>
                        <span>Kode: <strong>{{ $kunjungan->kode_kunjungan }}</strong></span>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Santri:</span>
                            <span class="text-primary">{{ $kunjungan->santri->nama }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Wali:</span>
                            <span class="text-primary">{{ $kunjungan->waliSantri->nama }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Nomor Antrian:</span>
                            <span class="text-primary">{{ $kunjungan->nomor_antrian }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Terdaftar:</span>
                            <span
                                class="text-primary">{{ $kunjungan->is_preregistered ? 'Pre-registered' : 'Walk-in' }}</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-6">
                            <h6 class="mb-1">Terdaftar pada:</h6>
                            <p class="mb-0">{{ $kunjungan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-1">Diupdate pada:</h6>
                            <p class="mb-0">{{ $kunjungan->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <div class="d-flex">
                            <i class="bx bx-info-circle me-2"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Informasi</h6>
                                <p class="mb-0">Perubahan jadwal kunjungan dapat mempengaruhi nomor antrian.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="card-header">Tindakan</h5>
                <div class="card-body">
                    <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="btn btn-info w-100 mb-2">
                        <i class="bx bx-show-alt me-1"></i> Lihat Detail
                    </a>

                    <form action="{{ route('admin.kunjungan.destroy', $kunjungan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 mb-2"
                            onclick="return confirm('Yakin ingin menghapus kunjungan ini?')">
                            <i class="bx bx-trash me-1"></i> Hapus Kunjungan
                        </button>
                    </form>

                    @if ($kunjungan->status != 'cancelled' && $kunjungan->status != 'completed')
                        <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-outline-danger w-100"
                                onclick="return confirm('Yakin ingin membatalkan kunjungan ini?')">
                                <i class="bx bx-x-circle me-1"></i> Batalkan Kunjungan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
