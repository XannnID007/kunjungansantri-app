@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('page-title', 'Detail Kunjungan')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Informasi Kunjungan</h4>
                        <div>
                            @if (in_array($kunjungan->status, ['pending', 'confirmed']))
                                <a href="{{ route('wali.kunjungan.edit', $kunjungan) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('wali.kunjungan.destroy', $kunjungan) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin membatalkan kunjungan ini?')">
                                        <i class="fas fa-times-circle"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div
                            class="status-badge p-3 {{ $kunjungan->status == 'completed' ? 'bg-success' : ($kunjungan->status == 'cancelled' ? 'bg-danger' : 'bg-info') }} text-white">
                            <h3 class="m-0">Status: {{ ucfirst($kunjungan->status) }}</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informasi Kunjungan</h5>
                            <table class="table">
                                <tr>
                                    <th width="40%">Kode Kunjungan</th>
                                    <td><strong>{{ $kunjungan->kode_kunjungan }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jam</th>
                                    <td>{{ \Carbon\Carbon::parse($kunjungan->jam_kunjungan)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Antrian</th>
                                    <td>{{ $kunjungan->nomor_antrian }}</td>
                                </tr>
                                <tr>
                                    <th>Tujuan Kunjungan</th>
                                    <td>{{ $kunjungan->tujuan_kunjungan }}</td>
                                </tr>
                                @if ($kunjungan->catatan)
                                    <tr>
                                        <th>Catatan</th>
                                        <td>{{ $kunjungan->catatan }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Informasi Santri</h5>
                            <table class="table">
                                <tr>
                                    <th width="40%">Nama Santri</th>
                                    <td>{{ $kunjungan->santri->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Kamar</th>
                                    <td>{{ $kunjungan->santri->kamar }}</td>
                                </tr>
                            </table>

                            @if ($kunjungan->waktu_kedatangan)
                                <h5 class="mt-3">Waktu Kunjungan</h5>
                                <table class="table">
                                    <tr>
                                        <th width="40%">Waktu Datang</th>
                                        <td>{{ $kunjungan->waktu_kedatangan ? $kunjungan->waktu_kedatangan->format('H:i') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Selesai</th>
                                        <td>{{ $kunjungan->waktu_selesai ? $kunjungan->waktu_selesai->format('H:i') : '-' }}
                                        </td>
                                    </tr>
                                    @if ($kunjungan->waktu_selesai)
                                        <tr>
                                            <th>Durasi</th>
                                            <td>{{ $kunjungan->durasi }} menit</td>
                                        </tr>
                                    @endif
                                </table>
                            @endif
                        </div>
                    </div>

                    <h5 class="mt-4">Barang Bawaan</h5>
                    @if ($kunjungan->barang->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kunjungan->barang as $barang)
                                        <tr>
                                            <td>{{ $barang->kode_barang }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->jumlah }}</td>
                                            <td>{!! $barang->status_label !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Tidak ada barang bawaan.</p>
                        </div>
                    @endif

                    <div class="text-center my-4">
                        <p>Tunjukkan QR Code ini saat kunjungan:</p>
                        {!! QrCode::size(150)->generate($kunjungan->kode_kunjungan) !!}
                        <p class="mt-2"><strong>{{ $kunjungan->kode_kunjungan }}</strong></p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('wali.kunjungan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <a href="{{ url('check-antrian', $kunjungan->kode_kunjungan) }}" class="btn btn-info float-right"
                        target="_blank">
                        <i class="fas fa-print"></i> Cetak Tiket
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
