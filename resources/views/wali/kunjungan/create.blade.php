@extends('layouts.app')

@section('title', 'Buat Kunjungan Baru')

@section('page-title', 'Pendaftaran Kunjungan')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Pendaftaran Kunjungan</h4>
                </div>
                <div class="card-body">
                    @if ($santri_list->isEmpty())
                        <div class="alert alert-warning">
                            <p>Anda tidak memiliki santri terdaftar. Silahkan hubungi admin untuk mendaftarkan santri.</p>
                        </div>
                    @elseif(empty($jadwal_tersedia))
                        <div class="alert alert-info">
                            <p>Tidak ada jadwal tersedia untuk saat ini. Silahkan coba lagi nanti.</p>
                        </div>
                    @else
                        <form action="{{ route('wali.kunjungan.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="santri_id">Pilih Santri:</label>
                                <select name="santri_id" id="santri_id"
                                    class="form-control @error('santri_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Santri --</option>
                                    @foreach ($santri_list as $santri)
                                        <option value="{{ $santri->id }}"
                                            {{ old('santri_id') == $santri->id ? 'selected' : '' }}>
                                            {{ $santri->nama }} - {{ $santri->kamar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('santri_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Jadwal Kunjungan:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tanggal_kunjungan">Pilih Tanggal:</label>
                                        <select name="tanggal_kunjungan" id="tanggal_kunjungan"
                                            class="form-control @error('tanggal_kunjungan') is-invalid @enderror" required>
                                            <option value="">-- Pilih Tanggal --</option>
                                            @php
                                                $grouped_jadwal = collect($jadwal_tersedia)->groupBy('tanggal');
                                            @endphp

                                            @foreach ($grouped_jadwal as $tanggal => $jadwals)
                                                <option value="{{ $tanggal }}"
                                                    {{ old('tanggal_kunjungan') == $tanggal ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tanggal_kunjungan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="jam_kunjungan">Pilih Jam:</label>
                                        <select name="jam_kunjungan" id="jam_kunjungan"
                                            class="form-control @error('jam_kunjungan') is-invalid @enderror" required>
                                            <option value="">-- Pilih Jam --</option>
                                        </select>
                                        @error('jam_kunjungan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tujuan_kunjungan">Tujuan Kunjungan:</label>
                                <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan"
                                    class="form-control @error('tujuan_kunjungan') is-invalid @enderror"
                                    value="{{ old('tujuan_kunjungan') }}" required>
                                @error('tujuan_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="catatan">Catatan (opsional):</label>
                                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Daftar Barang yang Dibawa (opsional):</label>
                                <div id="barang-container">
                                    <div class="barang-item mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="barang[0][nama_barang]" class="form-control"
                                                    placeholder="Nama Barang">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="barang[0][jumlah]" class="form-control"
                                                    placeholder="Jumlah" min="1" value="1">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="barang[0][deskripsi]" class="form-control"
                                                    placeholder="Deskripsi/Keterangan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="tambah-barang" class="btn btn-sm btn-info">
                                    <i class="fas fa-plus"></i> Tambah Barang
                                </button>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Daftar Kunjungan
                                </button>
                                <a href="{{ route('wali.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data jadwal tersedia
            const jadwalTersedia = @json($jadwal_tersedia);

            // Handle perubahan tanggal
            const tanggalSelect = document.getElementById('tanggal_kunjungan');
            const jamSelect = document.getElementById('jam_kunjungan');

            tanggalSelect.addEventListener('change', function() {
                const selectedTanggal = this.value;

                // Reset jam
                jamSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

                if (selectedTanggal) {
                    const filteredJadwal = jadwalTersedia.filter(j => j.tanggal === selectedTanggal);

                    filteredJadwal.forEach(jadwal => {
                        const option = document.createElement('option');
                        option.value = jadwal.jam;
                        option.textContent =
                            `${jadwal.jam} (Tersedia: ${jadwal.tersedia} dari ${jadwal.kuota})`;
                        jamSelect.appendChild(option);
                    });
                }
            });

            // Handle tambah barang
            const tambahBarangBtn = document.getElementById('tambah-barang');
            const barangContainer = document.getElementById('barang-container');
            let barangCount = 1;

            tambahBarangBtn.addEventListener('click', function() {
                const barangItem = document.createElement('div');
                barangItem.className = 'barang-item mb-3';
                barangItem.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="barang[${barangCount}][nama_barang]" class="form-control" placeholder="Nama Barang">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="barang[${barangCount}][jumlah]" class="form-control" placeholder="Jumlah" min="1" value="1">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="barang[${barangCount}][deskripsi]" class="form-control" placeholder="Deskripsi/Keterangan">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm hapus-barang">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

                barangContainer.appendChild(barangItem);
                barangCount++;

                // Handle hapus barang
                const hapusBarangBtns = document.querySelectorAll('.hapus-barang');
                hapusBarangBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.closest('.barang-item').remove();
                    });
                });
            });
        });
    </script>
@endpush
