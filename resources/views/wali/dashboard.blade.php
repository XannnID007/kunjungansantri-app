@extends('layouts.app')

@section('title', 'Dashboard Wali Santri')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Selamat Datang, {{ auth()->user()->name }}</h4>
                </div>
                <div class="card-body">
                    @php
                        $wali = auth()->user()->waliSantri;
                    @endphp

                    @if (!$wali)
                        <div class="alert alert-warning">
                            <p>Anda belum terdaftar sebagai wali santri. Silahkan hubungi admin untuk mendaftarkan diri.</p>
                        </div>
                    @else
                        <h5>Informasi Wali Santri</h5>
                        <table class="table">
                            <tr>
                                <th width="30%">Nama</th>
                                <td>{{ $wali->nama }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Identitas</th>
                                <td>{{ $wali->no_identitas }}</td>
                            </tr>
                            <tr>
                                <th>Nomor HP</th>
                                <td>{{ $wali->no_hp ?: 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $wali->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Hubungan</th>
                                <td>{{ $wali->hubungan }}</td>
                            </tr>
                        </table>

                        <h5 class="mt-4">Daftar Santri</h5>
                        @if ($wali->santri->count() > 0)
                            <div class="list-group">
                                @foreach ($wali->santri as $santri)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $santri->nama }}</h5>
                                            <small>{{ $santri->nis }}</small>
                                        </div>
                                        <p class="mb-1">Kamar: {{ $santri->kamar }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p>Anda belum memiliki santri terdaftar. Silahkan hubungi admin.</p>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('wali.kunjungan.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Buat Kunjungan Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kunjungan Terbaru</h4>
                </div>
                <div class="card-body">
                    @if ($wali)
                        @php
                            $kunjungan = \App\Models\Kunjungan::with(['santri'])
                                ->where('wali_id', $wali->id)
                                ->orderBy('tanggal_kunjungan', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp

                        @if ($kunjungan->count() > 0)
                            <div class="list-group">
                                @foreach ($kunjungan as $k)
                                    <a href="{{ route('wali.kunjungan.show', $k->id) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $k->santri->nama }}</h5>
                                            <small>{!! $k->status_label !!}</small>
                                        </div>
                                        <p class="mb-1">
                                            <strong>Tanggal:</strong>
                                            {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </p>
                                        <p class="mb-1">
                                            <strong>Jam:</strong>
                                            {{ \Carbon\Carbon::parse($k->jam_kunjungan)->format('H:i') }}
                                        </p>
                                        <small>
                                            <strong>Kode Kunjungan:</strong> {{ $k->kode_kunjungan }} -
                                            <strong>No. Antrian:</strong> {{ $k->nomor_antrian }}
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p>Anda belum memiliki riwayat kunjungan.</p>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <p>Anda belum terdaftar sebagai wali santri.</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('wali.kunjungan.index') }}" class="btn btn-info">
                        <i class="fas fa-history"></i> Lihat Semua Riwayat
                    </a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Jadwal Tersedia</h4>
                </div>
                <div class="card-body">
                    @php
                        $jadwal_operasional = \App\Models\JadwalOperasional::where('is_active', true)
                            ->get()
                            ->groupBy('hari');
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Operasional</th>
                                    <th>Kuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal_operasional as $hari => $jadwals)
                                    @foreach ($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $hari }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') }}</td>
                                            <td>{{ $jadwal->kuota_kunjungan }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('wali.jadwal-tersedia') }}" class="btn btn-success">
                        <i class="fas fa-calendar-check"></i> Lihat Jadwal Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
