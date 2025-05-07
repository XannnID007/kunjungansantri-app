@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-box fa-3x mb-3"></i>
                                        <h5>Laporan Barang</h5>
                                        <a href="{{ route('admin.laporan.barang') }}" class="btn btn-primary mt-3">
                                            Lihat Laporan
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-friends fa-3x mb-3"></i>
                                        <h5>Laporan Kunjungan</h5>
                                        <a href="{{ route('admin.laporan.kunjungan') }}" class="btn btn-primary mt-3">
                                            Lihat Laporan
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
