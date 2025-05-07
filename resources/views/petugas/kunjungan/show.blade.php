@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Kunjungan</h4>
                        <div class="card-tools">
                            <a href="{{ route('petugas.kunjungan.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th width="30%">Kode Kunjungan</th>
                                            <td width="5%">:</td>
                                            <td>{{ $kunjungan->kode }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal & Waktu</th>
                                            <td>:</td>
                                            <td>{{ $kunjungan->tanggal->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Durasi</th>
                                            <td>:</td>
                                            <td>{{ $kunjungan->durasi ?? '-' }} Menit</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>:</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $kunjungan->status == 'selesai' ? 'success' : ($kunjungan->status == 'berlangsung' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($kunjungan->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th width="30%">Pengunjung</th>
                                            <td width="5%">:</td>
                                            <td>{{ $kunjungan->pengunjung->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hubungan</th>
                                            <td>:</td>
                                            <td>
                                                @if ($kunjungan->pengunjung)
                                                    @if ($kunjungan->pengunjung->hubungan == 'lainnya')
                                                        {{ $kunjungan->pengunjung->hubungan_lainnya }}
                                                    @else
                                                        {{ ucfirst($kunjungan->pengunjung->hubungan) }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Santri</th>
                                            <td>:</td>
                                            <td>{{ $kunjungan->santri->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIS Santri</th>
                                            <td>:</td>
                                            <td>{{ $kunjungan->santri->nis ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Keterangan</h5>
                                    </div>
                                    <div class="card-body">
                                        {{ $kunjungan->keterangan ?? 'Tidak ada keterangan' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($kunjungan->status == 'berlangsung')
                            <div class="mt-4">
                                <form action="{{ route('petugas.kunjungan.selesai', $kunjungan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Apakah Anda yakin ingin menyelesaikan kunjungan ini?')">
                                        <i class="fas fa-check"></i> Selesaikan Kunjungan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
