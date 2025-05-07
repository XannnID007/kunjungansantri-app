@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Kunjungan</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.laporan.kunjungan.pdf') }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.laporan.kunjungan') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" class="form-control"
                                            value="{{ request('tanggal_awal') ?? date('Y-m-01') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" class="form-control"
                                            value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kunjungan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $item->pengunjung->nama }}</td>
                                            <td>{{ $item->santri->nama }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item->status == 'selesai' ? 'success' : ($item->status == 'berlangsung' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Data tidak tersedia</td>
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
