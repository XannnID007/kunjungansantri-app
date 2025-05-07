@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Manajemen Pengguna
    </h4>

    <!-- Filter dan Pencarian -->
    <div class="card mb-4">
        <h5 class="card-header">Filter Pengguna</h5>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label" for="role">Role</label>
                        <select id="role" name="role" class="form-select">
                            <option value="all"
                                {{ request()->role == 'all' || !request()->has('role') ? 'selected' : '' }}>Semua Role
                            </option>
                            <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ request()->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="wali_santri" {{ request()->role == 'wali_santri' ? 'selected' : '' }}>Wali Santri
                            </option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="search">Pencarian</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Cari nama, email..." value="{{ request()->search }}">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Data Pengguna
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Pengguna
            </a>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span
                                    class="badge bg-label-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'petugas' ? 'info' : 'success') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.users.toggleActive', $user) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="dropdown-item">
                                                <i
                                                    class="bx bx-{{ $user->is_active ? 'power-off' : 'check-circle' }} me-1"></i>
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        @if ($user->id != auth()->id())
                                            <!-- Cek agar tidak bisa menghapus diri sendiri -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengguna</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }}
                    data
                </div>
                <div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
