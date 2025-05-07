@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Kunjungan</h4>
                        <div class="card-tools">
                            <a href="{{ route('petugas.kunjungan.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('petugas.kunjungan.update', $kunjungan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode">Kode Kunjungan</label>
                                        <input type="text" name="kode" id="kode"
                                            class="form-control @error('kode') is-invalid @enderror"
                                            value="{{ old('kode', $kunjungan->kode) }}" readonly>
                                        @error('kode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal & Waktu</label>
                                        <input type="datetime-local" name="tanggal" id="tanggal"
                                            class="form-control @error('tanggal') is-invalid @enderror"
                                            value="{{ old('tanggal', $kunjungan->tanggal->format('Y-m-d\TH:i')) }}"
                                            required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="durasi">Durasi (Menit)</label>
                                        <input type="number" name="durasi" id="durasi"
                                            class="form-control @error('durasi') is-invalid @enderror"
                                            value="{{ old('durasi', $kunjungan->durasi) }}" min="5" required>
                                        @error('durasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pengunjung_id">Pengunjung</label>
                                        <select name="pengunjung_id" id="pengunjung_id"
                                            class="form-control @error('pengunjung_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Pengunjung --</option>
                                            @foreach ($waliSantri as $wali)
                                                <option value="{{ $wali->id }}"
                                                    {{ old('pengunjung_id', $kunjungan->pengunjung_id) == $wali->id ? 'selected' : '' }}>
                                                    {{ $wali->nama }} -
                                                    {{ $wali->hubungan == 'lainnya' ? $wali->hubungan_lainnya : ucfirst($wali->hubungan) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('pengunjung_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="santri_id">Santri</label>
                                        <select name="santri_id" id="santri_id"
                                            class="form-control @error('santri_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Santri --</option>
                                            @foreach ($santri as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ old('santri_id', $kunjungan->santri_id) == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama }} - {{ $s->nis }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('santri_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                            rows="3">{{ old('keterangan', $kunjungan->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
