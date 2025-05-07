@extends('layouts.app')

@section('title', 'Detail Barang')

@section('page-title', 'Detail Barang')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Barang</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($barang->foto)
                            <img src="{{ asset('storage/barang/' . $barang->foto) }}" class="img-fluid" alt="Foto Barang"
                                style="max-height: 200px;">
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-image fa-3x"></i>
                                <p class="mt-2">Tidak ada foto barang</p>
                            </div>
                        @endif
                    </div>

                    <table class="table">
                        <tr>
                            <th width="40%">Kode Barang</th>
                            <td>
                                <strong>{{ $barang->kode_barang }}</strong>
                                <div class="mt-1">
                                    {!! QrCode::size(100)->generate($barang->kode_barang) !!}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $barang->jumlah }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $barang->deskripsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{!! $barang->status_label !!}</td>
                        </tr>
                        @if ($barang->status == 'ditolak')
                            <tr>
                                <th>Alasan Ditolak</th>
                                <td>{{ $barang->alasan_ditolak }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Waktu Diserahkan</th>
                            <td>{{ $barang->waktu_diserahkan ? $barang->waktu_diserahkan->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Diterima</th>
                            <td>{{ $barang->waktu_diterima ? $barang->waktu_diterima->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('petugas.barang.label', $barang->id) }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-tag"></i> Cetak Label
                    </a>
                    <a href="{{ route('petugas.barang.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Kunjungan</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="40%">Kode Kunjungan</th>
                            <td><strong>{{ $barang->kunjungan->kode_kunjungan }}</strong></td>
                        </tr>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <td>{{ \Carbon\Carbon::parse($barang->kunjungan->tanggal_kunjungan)->locale('id')->isoFormat('D MMMM Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Jam Kunjungan</th>
                            <td>{{ \Carbon\Carbon::parse($barang->kunjungan->jam_kunjungan)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status Kunjungan</th>
                            <td>{!! $barang->kunjungan->status_label !!}</td>
                        </tr>
                        <tr>
                            <th>Santri</th>
                            <td>{{ $barang->kunjungan->santri->nama }}</td>
                        </tr>
                        <tr>
                            <th>Wali Santri</th>
                            <td>{{ $barang->kunjungan->waliSantri->nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('petugas.kunjungan.show', $barang->kunjungan->id) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Detail Kunjungan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Status Barang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.barang.update-status', $barang->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="status">Pilih Status:</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Status --</option>
                                <option value="diserahkan" {{ $barang->status == 'diserahkan' ? 'selected' : '' }}>
                                    Diserahkan</option>
                                <option value="diterima" {{ $barang->status == 'diterima' ? 'selected' : '' }}>Diterima
                                </option>
                                <option value="dikembalikan" {{ $barang->status == 'dikembalikan' ? 'selected' : '' }}>
                                    Dikembalikan</option>
                                <option value="ditolak" {{ $barang->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="alasan-container" style="display: none;">
                            <label for="alasan_ditolak">Alasan Ditolak:</label>
                            <textarea name="alasan_ditolak" id="alasan_ditolak" class="form-control @error('alasan_ditolak') is-invalid @enderror"
                                rows="3">{{ old('alasan_ditolak', $barang->alasan_ditolak) }}</textarea>
                            @error('alasan_ditolak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Upload Foto (opsional):</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control-file @error('foto') is-invalid @enderror">
                            <small class="form-text text-muted">Upload foto baru jika ingin memperbarui foto barang.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const alasanContainer = document.getElementById('alasan-container');

            // Tampilkan/sembunyikan field alasan berdasarkan status yang dipilih
            function toggleAlasanField() {
                if (statusSelect.value === 'ditolak') {
                    alasanContainer.style.display = 'block';
                } else {
                    alasanContainer.style.display = 'none';
                }
            }

            // Check initial status
            toggleAlasanField();

            // Listen for changes
            statusSelect.addEventListener('change', toggleAlasanField);
        });
    </script>
@endpush
