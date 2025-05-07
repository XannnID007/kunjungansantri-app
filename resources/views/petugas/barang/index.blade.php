@extends('layouts.app')

@section('title', 'Data Barang')

@section('page-title', 'Daftar Barang')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Barang</h4>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scanBarangModal">
                                <i class="fas fa-qrcode"></i> Scan Barang
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.barang.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search">Cari:</label>
                                    <input type="text" name="search" id="search" class="form-control"
                                        placeholder="Kode, nama barang..." value="{{ request()->search }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>Semua
                                            Status</option>
                                        <option value="diserahkan"
                                            {{ request()->status == 'diserahkan' ? 'selected' : '' }}>Diserahkan</option>
                                        <option value="diterima" {{ request()->status == 'diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="dikembalikan"
                                            {{ request()->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan
                                        </option>
                                        <option value="ditolak" {{ request()->status == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal:</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        value="{{ request()->tanggal }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Santri</th>
                                    <th>Wali</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $b)
                                    <tr>
                                        <td>{{ $b->kode_barang }}</td>
                                        <td>{{ $b->nama_barang }}</td>
                                        <td>{{ $b->kunjungan->santri->nama }}</td>
                                        <td>{{ $b->kunjungan->waliSantri->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->kunjungan->tanggal_kunjungan)->format('d/m/Y') }}
                                        </td>
                                        <td>{!! $b->status_label !!}</td>
                                        <td>
                                            <a href="{{ route('petugas.barang.show', $b) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('petugas.barang.label', $b) }}"
                                                class="btn btn-primary btn-sm" target="_blank">
                                                <i class="fas fa-tag"></i> Label
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data barang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $barang->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Scan Barang -->
    <div class="modal fade" id="scanBarangModal" tabindex="-1" role="dialog" aria-labelledby="scanBarangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanBarangModalLabel">Scan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('petugas.barang.scan') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang:</label>
                            <input type="text" name="kode_barang" id="kode_barang" class="form-control"
                                placeholder="Masukkan kode barang..." required>
                            <small class="form-text text-muted">Scan kode QR atau masukkan kode barang secara
                                manual.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cari Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
