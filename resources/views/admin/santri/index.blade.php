@extends('layouts.app')

@section('title', 'Daftar Santri')

@section('page-title', 'Data Santri')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Santri</h4>
                        <a href="{{ route('admin.santri.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Santri
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.santri.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama, NIS, atau kamar..." value="{{ request()->search }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kamar</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($santri as $s)
                                    <tr>
                                        <td>{{ $loop->iteration + ($santri->currentPage() - 1) * $santri->perPage() }}</td>
                                        <td>{{ $s->nis }}</td>
                                        <td>{{ $s->nama }}</td>
                                        <td>{{ $s->kamar }}</td>
                                        <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>
                                            @if ($s->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.santri.show', $s) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye">Detail</i>
                                            </a>
                                            <a href="{{ route('admin.santri.edit', $s) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit">Edit</i>
                                            </a>
                                            <form action="{{ route('admin.santri.destroy', $s) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus santri ini?')">
                                                    <i class="fas fa-trash">Hapus</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data santri</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $santri->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
