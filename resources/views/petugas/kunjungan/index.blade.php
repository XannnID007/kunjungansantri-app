@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Kunjungan</h4>
                        <div class="card-tools">
                            <a href="{{ route('petugas.kunjungan.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Tambah Kunjungan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Pengunjung</th>
                                        <th>Santri</th>
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
                                            <td>{{ $item->pengunjung->nama ?? '-' }}</td>
                                            <td>{{ $item->santri->nama ?? '-' }}</td>
                                            <td>{{ $item->durasi ?? '-' }} Menit</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->status == 'selesai' ? 'success' : ($item->status == 'berlangsung' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('petugas.kunjungan.show', $item->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if ($item->status != 'selesai')
                                                    <a href="{{ route('petugas.kunjungan.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($item->status == 'berlangsung')
                                                    <form action="{{ route('petugas.kunjungan.selesai', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyelesaikan kunjungan ini?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data tidak tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $kunjungan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
