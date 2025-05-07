@extends('layouts.app')

@section('title', 'Data Kunjungan')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Data Kunjungan
    </h4>

    <!-- Filter dan Pencarian -->
    <div class="card mb-4">
        <h5 class="card-header">Filter Kunjungan</h5>
        <div class="card-body">
            <form action="{{ route('admin.kunjungan.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label" for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request()->start_date }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request()->end_date }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="status">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="all"
                                {{ request()->status == 'all' || !request()->has('status') ? 'selected' : '' }}>Semua Status
                            </option>
                            <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="checked_in" {{ request()->status == 'checked_in' ? 'selected' : '' }}>Checked In
                            </option>
                            <option value="in_progress" {{ request()->status == 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="completed" {{ request()->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request()->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="search">Pencarian</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Cari kode, santri, wali..." value="{{ request()->search }}">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kunjungan -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Data Kunjungan
            <a href="{{ route('admin.kunjungan.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Kunjungan
            </a>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Santri</th>
                        <th>Wali</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($kunjungan as $k)
                        <tr>
                            <td><strong>{{ $k->kode_kunjungan }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($k->jam_kunjungan)->format('H:i') }}</td>
                            <td>{{ $k->santri->nama }}</td>
                            <td>{{ $k->waliSantri->nama }}</td>
                            <td>
                                <span
                                    class="badge bg-label-{{ $k->status == 'pending'
                                        ? 'warning'
                                        : ($k->status == 'confirmed'
                                            ? 'info'
                                            : ($k->status == 'checked_in'
                                                ? 'primary'
                                                : ($k->status == 'in_progress'
                                                    ? 'success'
                                                    : ($k->status == 'completed'
                                                        ? 'secondary'
                                                        : 'danger')))) }}">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                            <td>{{ $k->is_preregistered ? 'Pre-registered' : 'Walk-in' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.kunjungan.show', $k->id) }}">
                                            <i class="bx bx-show-alt me-1"></i> Detail
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.kunjungan.edit', $k->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kunjungan.destroy', $k->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Yakin ingin menghapus kunjungan ini?')">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </form>

                                        <!-- Update Status Action -->
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#updateStatusModal{{ $k->id }}">
                                            <i class="bx bx-revision me-1"></i> Update Status
                                        </a>
                                    </div>
                                </div>

                                <!-- Modal Update Status -->
                                <div class="modal fade" id="updateStatusModal{{ $k->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Status Kunjungan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.kunjungan.updateStatus', $k->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" id="status" class="form-select">
                                                                <option value="pending"
                                                                    {{ $k->status == 'pending' ? 'selected' : '' }}>Pending
                                                                </option>
                                                                <option value="confirmed"
                                                                    {{ $k->status == 'confirmed' ? 'selected' : '' }}>
                                                                    Confirmed</option>
                                                                <option value="checked_in"
                                                                    {{ $k->status == 'checked_in' ? 'selected' : '' }}>
                                                                    Checked In</option>
                                                                <option value="in_progress"
                                                                    {{ $k->status == 'in_progress' ? 'selected' : '' }}>In
                                                                    Progress</option>
                                                                <option value="completed"
                                                                    {{ $k->status == 'completed' ? 'selected' : '' }}>
                                                                    Completed</option>
                                                                <option value="cancelled"
                                                                    {{ $k->status == 'cancelled' ? 'selected' : '' }}>
                                                                    Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data kunjungan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Menampilkan {{ $kunjungan->firstItem() ?? 0 }} - {{ $kunjungan->lastItem() ?? 0 }} dari
                    {{ $kunjungan->total() }} data
                </div>
                <div>
                    {{ $kunjungan->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
