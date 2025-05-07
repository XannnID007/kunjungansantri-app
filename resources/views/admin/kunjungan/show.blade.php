@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin / <a href="{{ route('admin.kunjungan.index') }}">Data Kunjungan</a> /</span>
        Detail Kunjungan
    </h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Kunjungan</h5>
                    <div>
                        <a href="{{ route('admin.kunjungan.edit', $kunjungan->id) }}" class="btn btn-primary btn-sm">
                            <i class="bx bx-edit-alt"></i> Edit
                        </a>
                        <button class="btn btn-outline-primary btn-sm ms-2 btn-print">
                            <i class="bx bx-printer"></i> Cetak
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="print-area">
                        <div class="tiket-kunjungan">
                            <div class="tiket-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">Tiket Kunjungan</h3>
                                    <span
                                        class="badge bg-label-{{ $kunjungan->status == 'pending'
                                            ? 'warning'
                                            : ($kunjungan->status == 'confirmed'
                                                ? 'info'
                                                : ($kunjungan->status == 'checked_in'
                                                    ? 'primary'
                                                    : ($kunjungan->status == 'in_progress'
                                                        ? 'success'
                                                        : ($kunjungan->status == 'completed'
                                                            ? 'secondary'
                                                            : 'danger')))) }} fw-bold">
                                        {{ ucfirst($kunjungan->status) }}
                                    </span>
                                </div>
                                <p class="mb-0 text-muted">Kode: {{ $kunjungan->kode_kunjungan }}</p>
                            </div>

                            <div class="tiket-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Kunjungan</label>
                                            <p class="form-control-static">
                                                {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jam Kunjungan</label>
                                            <p class="form-control-static">
                                                {{ \Carbon\Carbon::parse($kunjungan->jam_kunjungan)->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nomor Antrian</label>
                                            <p class="form-control-static">{{ $kunjungan->nomor_antrian }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Terdaftar</label>
                                            <p class="form-control-static">
                                                {{ $kunjungan->is_preregistered ? 'Pre-registered' : 'Walk-in' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Tujuan Kunjungan</label>
                                            <p class="form-control-static">{{ $kunjungan->tujuan_kunjungan }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Catatan</label>
                                            <p class="form-control-static">{{ $kunjungan->catatan ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <label class="d-block mb-1">Santri</label>
                                        <div class="d-flex align-items-center">
                                            @if ($kunjungan->santri->foto)
                                                <img src="{{ asset('storage/santri/' . $kunjungan->santri->foto) }}"
                                                    class="d-block rounded me-2" width="54" height="54">
                                            @else
                                                <div class="avatar me-2">
                                                    <span
                                                        class="avatar-initial rounded bg-label-primary">{{ substr($kunjungan->santri->nama, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $kunjungan->santri->nama }}</h6>
                                                <small class="text-muted">Kamar: {{ $kunjungan->santri->kamar }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="d-block mb-1">Wali Santri</label>
                                        <div class="d-flex align-items-center">
                                            @if ($kunjungan->waliSantri->foto)
                                                <img src="{{ asset('storage/wali/' . $kunjungan->waliSantri->foto) }}"
                                                    class="d-block rounded me-2" width="54" height="54">
                                            @else
                                                <div class="avatar me-2">
                                                    <span
                                                        class="avatar-initial rounded bg-label-success">{{ substr($kunjungan->waliSantri->nama, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $kunjungan->waliSantri->nama }}</h6>
                                                <small class="text-muted">Hubungan:
                                                    {{ $kunjungan->waliSantri->hubungan }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tiket-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="qr-container">
                                            {!! QrCode::size(100)->generate($kunjungan->kode_kunjungan) !!}
                                            <p class="mb-0 mt-2"><small>{{ $kunjungan->kode_kunjungan }}</small></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end d-flex flex-column justify-content-between">
                                        <div>
                                            <p class="mb-0"><small>Didaftarkan oleh:
                                                    {{ $kunjungan->registered_by }}</small></p>
                                            <p class="mb-0"><small>Tanggal daftar:
                                                    {{ $kunjungan->created_at->format('d/m/Y H:i') }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card">
                <h5 class="card-header">Riwayat Status</h5>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent">
                            <span
                                class="timeline-point timeline-point-{{ $kunjungan->status == 'pending' || $kunjungan->status == 'confirmed' || $kunjungan->status == 'checked_in' || $kunjungan->status == 'in_progress' || $kunjungan->status == 'completed' ? 'success' : 'danger' }}"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Pendaftaran</h6>
                                    <small class="text-muted">{{ $kunjungan->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <p class="mb-0">Kunjungan telah didaftarkan oleh {{ $kunjungan->registered_by }}</p>
                            </div>
                        </li>

                        @if (
                            $kunjungan->status == 'confirmed' ||
                                $kunjungan->status == 'checked_in' ||
                                $kunjungan->status == 'in_progress' ||
                                $kunjungan->status == 'completed')
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-info"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Konfirmasi</h6>
                                        <small class="text-muted">{{ $kunjungan->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0">Kunjungan telah dikonfirmasi</p>
                                </div>
                            </li>
                        @endif

                        @if ($kunjungan->status == 'checked_in' || $kunjungan->status == 'in_progress' || $kunjungan->status == 'completed')
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Check In</h6>
                                        <small
                                            class="text-muted">{{ $kunjungan->waktu_kedatangan ? $kunjungan->waktu_kedatangan->format('d/m/Y H:i') : '-' }}</small>
                                    </div>
                                    <p class="mb-0">Wali santri telah check in</p>
                                </div>
                            </li>
                        @endif

                        @if ($kunjungan->status == 'in_progress' || $kunjungan->status == 'completed')
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-success"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Kunjungan Berlangsung</h6>
                                        <small
                                            class="text-muted">{{ $kunjungan->waktu_kedatangan ? $kunjungan->waktu_kedatangan->format('d/m/Y H:i') : '-' }}</small>
                                    </div>
                                    <p class="mb-0">Kunjungan sedang berlangsung</p>
                                </div>
                            </li>
                        @endif

                        @if ($kunjungan->status == 'completed')
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-secondary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Kunjungan Selesai</h6>
                                        <small
                                            class="text-muted">{{ $kunjungan->waktu_selesai ? $kunjungan->waktu_selesai->format('d/m/Y H:i') : '-' }}</small>
                                    </div>
                                    <p class="mb-0">Kunjungan telah selesai</p>
                                </div>
                            </li>
                        @endif

                        @if ($kunjungan->status == 'cancelled')
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-danger"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Kunjungan Dibatalkan</h6>
                                        <small
                                            class="text-muted">{{ $kunjungan->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0">Kunjungan telah dibatalkan</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Barang Kunjungan -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Barang Kunjungan</h5>
                    @if (in_array($kunjungan->status, ['pending', 'confirmed', 'checked_in', 'in_progress']))
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addBarangModal">
                            <i class="bx bx-plus"></i> Tambah Barang
                        </button>
                    @endif
                </div>
                <div class="table-responsive">
                    @if ($kunjungan->barang->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kunjungan->barang as $barang)
                                    <tr>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->jumlah }}</td>
                                        <td>
                                            <span
                                                class="badge bg-label-{{ $barang->status == 'diserahkan'
                                                    ? 'info'
                                                    : ($barang->status == 'diterima'
                                                        ? 'success'
                                                        : ($barang->status == 'dikembalikan'
                                                            ? 'secondary'
                                                            : 'danger')) }}">
                                                {{ ucfirst($barang->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editBarangModal{{ $barang->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </button>
                                                    <a href="{{ route('admin.barang.label', $barang->id) }}"
                                                        class="dropdown-item" target="_blank">
                                                        <i class="bx bx-printer me-1"></i> Cetak Label
                                                    </a>
                                                    <form action="{{ route('admin.barang.destroy', $barang->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"
                                                            onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                                            <i class="bx bx-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal Edit Barang -->
                                            <div class="modal fade" id="editBarangModal{{ $barang->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Barang</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.barang.update', $barang->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12 mb-3">
                                                                        <label for="nama_barang" class="form-label">Nama
                                                                            Barang</label>
                                                                        <input type="text" name="nama_barang"
                                                                            id="nama_barang" class="form-control"
                                                                            value="{{ $barang->nama_barang }}" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="jumlah"
                                                                            class="form-label">Jumlah</label>
                                                                        <input type="number" name="jumlah"
                                                                            id="jumlah" class="form-control"
                                                                            value="{{ $barang->jumlah }}" min="1"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="status"
                                                                            class="form-label">Status</label>
                                                                        <select name="status" id="status"
                                                                            class="form-select" required>
                                                                            <option value="diserahkan"
                                                                                {{ $barang->status == 'diserahkan' ? 'selected' : '' }}>
                                                                                Diserahkan</option>
                                                                            <option value="diterima"
                                                                                {{ $barang->status == 'diterima' ? 'selected' : '' }}>
                                                                                Diterima</option>
                                                                            <option value="dikembalikan"
                                                                                {{ $barang->status == 'dikembalikan' ? 'selected' : '' }}>
                                                                                Dikembalikan</option>
                                                                            <option value="ditolak"
                                                                                {{ $barang->status == 'ditolak' ? 'selected' : '' }}>
                                                                                Ditolak</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="deskripsi"
                                                                            class="form-label">Deskripsi</label>
                                                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $barang->deskripsi }}</textarea>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="foto" class="form-label">Foto
                                                                            (Opsional)</label>
                                                                        <input type="file" name="foto"
                                                                            id="foto" class="form-control">
                                                                        @if ($barang->foto)
                                                                            <small class="text-muted">Sudah ada foto
                                                                                sebelumnya. Upload hanya jika ingin
                                                                                mengubah.</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Batal
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-4 text-center">
                            <img src="{{ asset('template/assets/img/illustrations/girl-doing-yoga-light.png') }}"
                                alt="No Items" width="140" class="mb-3">
                            <p>Tidak ada barang yang terdaftar untuk kunjungan ini.</p>
                            @if (in_array($kunjungan->status, ['pending', 'confirmed', 'checked_in', 'in_progress']))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addBarangModal">
                                    <i class="bx bx-plus"></i> Tambah Barang
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Tambah Barang -->
            <div class="modal fade" id="addBarangModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                                            value="1" min="1" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="diserahkan">Diserahkan</option>
                                            <option value="diterima">Diterima</option>
                                            <option value="dikembalikan">Dikembalikan</option>
                                            <option value="ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="foto" class="form-label">Foto (Opsional)</label>
                                        <input type="file" name="foto" id="foto" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Status Card -->
            <div class="card">
                <h5 class="card-header">Update Status Kunjungan</h5>
                <div class="card-body">
                    <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-8">
                                <select name="status" class="form-select" required>
                                    <option value="pending" {{ $kunjungan->status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="confirmed" {{ $kunjungan->status == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="checked_in" {{ $kunjungan->status == 'checked_in' ? 'selected' : '' }}>
                                        Checked In</option>
                                    <option value="in_progress"
                                        {{ $kunjungan->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $kunjungan->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ $kunjungan->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Update Status</button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-4">
                        <h6>Status Saat Ini:</h6>
                        <div class="d-flex align-items-center gap-2">
                            <div
                                class="badge p-2 bg-label-{{ $kunjungan->status == 'pending'
                                    ? 'warning'
                                    : ($kunjungan->status == 'confirmed'
                                        ? 'info'
                                        : ($kunjungan->status == 'checked_in'
                                            ? 'primary'
                                            : ($kunjungan->status == 'in_progress'
                                                ? 'success'
                                                : ($kunjungan->status == 'completed'
                                                    ? 'secondary'
                                                    : 'danger')))) }}">
                                <i
                                    class="bx bx-{{ $kunjungan->status == 'pending'
                                        ? 'time'
                                        : ($kunjungan->status == 'confirmed'
                                            ? 'check-double'
                                            : ($kunjungan->status == 'checked_in'
                                                ? 'log-in'
                                                : ($kunjungan->status == 'in_progress'
                                                    ? 'loader'
                                                    : ($kunjungan->status == 'completed'
                                                        ? 'check-circle'
                                                        : 'x-circle')))) }} me-1"></i>
                                {{ ucfirst($kunjungan->status) }}
                            </div>
                            <span>sejak {{ $kunjungan->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        // Print functionality
        document.querySelector('.btn-print').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection
