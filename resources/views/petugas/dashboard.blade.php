@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-calendar-check text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">Kunjungan Hari Ini</p>
                                <h4 class="card-title">{{ $kunjungan_hari_ini }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="fas fa-calendar-alt"></i> Hari Ini
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-spinner text-success"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">Berlangsung</p>
                                <h4 class="card-title">{{ $kunjungan_berlangsung }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="fas fa-clock"></i> Saat Ini
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">Selesai</p>
                                <h4 class="card-title">{{ $kunjungan_selesai }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="fas fa-calendar-alt"></i> Hari Ini
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-box text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers">
                                <p class="card-category">Barang</p>
                                <h4 class="card-title">{{ $barang_hari_ini }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="fas fa-calendar-alt"></i> Hari Ini
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kunjungan Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Santri</th>
                                    <th>Wali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kunjungan_terbaru as $kunjungan)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($kunjungan->jam_kunjungan)->format('H:i') }}</td>
                                        <td>{{ $kunjungan->santri->nama }}</td>
                                        <td>{{ $kunjungan->waliSantri->nama }}</td>
                                        <td>{!! $kunjungan->status_label !!}</td>
                                        <td>
                                            <a href="{{ route('petugas.kunjungan.show', $kunjungan) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada kunjungan terbaru</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('petugas.kunjungan.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Menu Cepat</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('petugas.antrian.index') }}" class="btn btn-primary btn-lg mb-3">
                            <i class="fas fa-people-arrows"></i> Kelola Antrian
                        </a>
                        <a href="{{ route('petugas.kunjungan.index') }}" class="btn btn-info btn-lg mb-3">
                            <i class="fas fa-clipboard-list"></i> Data Kunjungan
                        </a>
                        <a href="{{ route('petugas.barang.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-box"></i> Pengaturan Barang
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Barang Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($barang_terbaru as $barang)
                            <a href="{{ route('petugas.barang.show', $barang) }}"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $barang->nama_barang }}</h5>
                                    {!! $barang->status_label !!}
                                </div>
                                <p class="mb-1">Santri: {{ $barang->kunjungan->santri->nama }}</p>
                                <small>Kode: {{ $barang->kode_barang }}</small>
                            </a>
                        @empty
                            <div class="alert alert-info">
                                <p>Tidak ada barang terbaru</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
