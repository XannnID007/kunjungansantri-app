@extends('layouts.app')

@section('title', 'Jadwal Operasional')

@section('page-title', 'Jadwal Operasional Kunjungan')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Jadwal Operasional</h4>
                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($hari as $h)
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">{{ $h }}</h5>
                            </div>
                            <div class="card-body">
                                @if (isset($jadwal[$h]) && $jadwal[$h]->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Jam Operasional</th>
                                                    <th>Kuota Kunjungan</th>
                                                    <th>Status</th>
                                                    <th>Catatan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jadwal[$h] as $j)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($j->jam_buka)->format('H:i') }} -
                                                            {{ \Carbon\Carbon::parse($j->jam_tutup)->format('H:i') }}</td>
                                                        <td>{{ $j->kuota_kunjungan }}</td>
                                                        <td>
                                                            @if ($j->is_active)
                                                                <span class="badge bg-success">Aktif</span>
                                                            @else
                                                                <span class="badge bg-danger">Tidak Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $j->catatan ?: '-' }}</td>
                                                        <td>
                                                            <form action="{{ route('admin.jadwal.toggleStatus', $j) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="btn btn-{{ $j->is_active ? 'warning' : 'success' }} btn-sm">
                                                                    <i
                                                                        class="fas fa-{{ $j->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                                                                    {{ $j->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                                </button>
                                                            </form>

                                                            <a href="{{ route('admin.jadwal.edit', $j) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('admin.jadwal.destroy', $j) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <p>Tidak ada jadwal operasional untuk hari {{ $h }}.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
