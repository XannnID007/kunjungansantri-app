@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Wali Santri</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-sm btn-secondary">
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
                                            <th width="30%">Nama Lengkap</th>
                                            <td width="5%">:</td>
                                            <td>{{ $waliSantri->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor HP</th>
                                            <td>:</td>
                                            <td>{{ $waliSantri->no_hp }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>:</td>
                                            <td>{{ $waliSantri->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hubungan</th>
                                            <td>:</td>
                                            <td>
                                                @if ($waliSantri->hubungan == 'lainnya')
                                                    {{ $waliSantri->hubungan_lainnya }}
                                                @else
                                                    {{ ucfirst($waliSantri->hubungan) }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th width="30%">Santri</th>
                                            <td width="5%">:</td>
                                            <td>{{ $waliSantri->santri->nama ?? 'Belum ditentukan' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIS Santri</th>
                                            <td>:</td>
                                            <td>{{ $waliSantri->santri->nis ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Akun</th>
                                            <td>:</td>
                                            <td>
                                                @if ($waliSantri->user)
                                                    <span class="badge bg-success">Sudah memiliki akun</span>
                                                @else
                                                    <span class="badge bg-warning">Belum memiliki akun</span>
                                                    <a href="{{ route('admin.wali-santri.create-account', ['wali_id' => $waliSantri->id]) }}"
                                                        class="btn btn-sm btn-info ml-2">
                                                        <i class="fas fa-user-plus"></i> Buat Akun
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($waliSantri->user)
                                            <tr>
                                                <th>Email</th>
                                                <td>:</td>
                                                <td>{{ $waliSantri->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Akun</th>
                                                <td>:</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $waliSantri->user->is_active ? 'success' : 'danger' }}">
                                                        {{ $waliSantri->user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Kunjungan -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Riwayat Kunjungan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kunjungan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->tanggal->format('d/m/Y H:i') }}</td>
                                            <td>{{ $item->durasi ?? '-' }} Menit</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->status == 'selesai' ? 'success' : ($item->status == 'berlangsung' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.kunjungan.show', $item->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada riwayat kunjungan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
