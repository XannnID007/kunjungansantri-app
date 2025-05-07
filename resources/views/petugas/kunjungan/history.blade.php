@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Riwayat Kunjungan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('petugas.kunjungan.history') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" class="form-control"
                                            value="{{ request('tanggal_awal') ?? date('Y-m-01') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" class="form-control"
                                            value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Santri</label>
                                        <select name="santri_id" class="form-control">
                                            <option value="">Semua Santri</option>
                                            @foreach ($santri as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ request('santri_id') == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama }} - {{ $s->nis }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary d-block w-100">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

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
                                        <th width="10%">Aksi</th>
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
