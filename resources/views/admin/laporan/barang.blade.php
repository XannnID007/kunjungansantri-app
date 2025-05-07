@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Barang</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.laporan.barang') }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($barang as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->kategori->nama }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item->status ? 'success' : 'danger' }}">
                                                    {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
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
