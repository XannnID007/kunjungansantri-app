@extends('layouts.app')

@section('title', 'Detail Santri')

@section('page-title', 'Detail Santri')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Santri</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($santri->foto)
                            <img src="{{ asset('storage/santri/' . $santri->foto) }}" class="img-fluid rounded"
                                alt="Foto Santri" style="max-height: 200px;">
                        @else
                            <img src="https://via.placeholder.com/200" class="img-fluid rounded" alt="No Photo">
                        @endif
                    </div>

                    <table class="table">
                        <tr>
                            <th width="35%">Nomor Induk Santri</th>
                            <td>{{ $santri->nis }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $santri->nama }}</td>
                        </tr>
                        <tr>
                            <th>Kamar</th>
                            <td>{{ $santri->kamar }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $santri->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($santri->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Wali Santri</h4>
                </div>
                <div class="card-body">
                    @if ($santri->waliSantri->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Wali</th>
                                        <th>Hubungan</th>
                                        <th>No. HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($santri->waliSantri as $wali)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $wali->nama }}</td>
                                            <td>{{ $wali->hubungan }}</td>
                                            <td>{{ $wali->no_hp ?: '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.wali-santri.show', $wali) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Santri ini belum memiliki wali terdaftar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Riwayat Kunjungan</h4>
                </div>
                <div class="card-body">
                    @php
                        $kunjungan = $santri
                            ->kunjungan()
                            ->with('waliSantri')
                            ->orderBy('tanggal_kunjungan', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp

                    @if ($kunjungan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Wali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kunjungan as $k)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d/m/Y') }}</td>
                                            <td>{{ $k->waliSantri->nama }}</td>
                                            <td>{!! $k->status_label !!}</td>
                                            <td>
                                                <a href="{{ route('admin.kunjungan.show', $k) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('admin.kunjungan.index', ['search' => $santri->nama]) }}"
                                class="btn btn-primary btn-sm">
                                Lihat Semua Kunjungan
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Belum ada riwayat kunjungan untuk santri ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
