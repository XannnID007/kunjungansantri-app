@extends('layouts.app')

@section('title', 'Kelola Antrian Kunjungan')

@section('page-title', 'Antrian Kunjungan')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kunjungan Sedang Berlangsung</h4>
                </div>
                <div class="card-body">
                    @if ($current_kunjungan->count() > 0)
                        @foreach ($current_kunjungan as $kunjungan)
                            <div class="alert alert-info">
                                <h4>Nomor Antrian: {{ $kunjungan->nomor_antrian }}</h4>
                                <p>Santri: <strong>{{ $kunjungan->santri->nama }}</strong></p>
                                <p>Wali: <strong>{{ $kunjungan->waliSantri->nama }}</strong></p>
                                <p>
                                    Mulai Kunjungan:
                                    <strong>{{ $kunjungan->waktu_kedatangan ? $kunjungan->waktu_kedatangan->format('H:i') : '-' }}</strong>
                                </p>
                                <p>Durasi: <strong>{{ $kunjungan->estimasi_durasi }} menit</strong></p>

                                <form action="{{ route('petugas.antrian.complete', $kunjungan->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                </form>

                                <a href="{{ route('petugas.kunjungan.show', $kunjungan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            <p>Tidak ada kunjungan yang sedang berlangsung</p>
                        </div>
                    @endif

                    <hr>

                    <div class="text-center">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#walkInModal">
                            <i class="fas fa-plus"></i> Daftarkan Walk-in
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Antrian Kunjungan Hari Ini</h4>
                    <p class="card-category">{{ \Carbon\Carbon::parse($today)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($kunjungan_hari_ini as $jam => $kunjungan_list)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="jam-{{ str_replace(':', '', $jam) }}-tab" data-toggle="tab"
                                    href="#jam-{{ str_replace(':', '', $jam) }}" role="tab">
                                    {{ $jam }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-3" id="myTabContent">
                        @foreach ($kunjungan_hari_ini as $jam => $kunjungan_list)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="jam-{{ str_replace(':', '', $jam) }}" role="tabpanel">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Jadwal Jam: {{ $jam }}</h5>

                                    <form action="{{ route('petugas.antrian.next') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jam_kunjungan" value="{{ $jam }}">
                                        <input type="hidden" name="tanggal" value="{{ $today }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-forward"></i> Panggil Berikutnya
                                        </button>
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No. Antrian</th>
                                                <th>Santri</th>
                                                <th>Wali</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($kunjungan_list->sortBy('nomor_antrian') as $kunjungan)
                                                <tr
                                                    class="{{ $kunjungan->status == 'in_progress' ? 'table-success' : '' }}">
                                                    <td>{{ $kunjungan->nomor_antrian }}</td>
                                                    <td>{{ $kunjungan->santri->nama }}</td>
                                                    <td>{{ $kunjungan->waliSantri->nama }}</td>
                                                    <td>{!! $kunjungan->status_label !!}</td>
                                                    <td>
                                                        @if ($kunjungan->status == 'confirmed')
                                                            <form action="{{ route('petugas.antrian.check-in') }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="kode_kunjungan"
                                                                    value="{{ $kunjungan->kode_kunjungan }}">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-sign-in-alt"></i> Check In
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <a href="{{ route('petugas.kunjungan.show', $kunjungan->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>

                                                        @if (!in_array($kunjungan->status, ['in_progress', 'completed', 'cancelled']))
                                                            <form
                                                                action="{{ route('petugas.antrian.cancel', $kunjungan->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan kunjungan ini?')">
                                                                    <i class="fas fa-times"></i> Batal
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada antrian pada jam ini
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Walk-In -->
    <div class="modal fade" id="walkInModal" tabindex="-1" role="dialog" aria-labelledby="walkInModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="walkInModalLabel">Pendaftaran Kunjungan Walk-In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('petugas.antrian.register-walk') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="wali_id">Wali Santri:</label>
                            <select name="wali_id" id="wali_id" class="form-control" required>
                                <option value="">-- Pilih Wali Santri --</option>
                                @foreach (\App\Models\WaliSantri::orderBy('nama')->get() as $wali)
                                    <option value="{{ $wali->id }}">{{ $wali->nama }} ({{ $wali->no_identitas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="santri_id">Santri:</label>
                            <select name="santri_id" id="santri_id" class="form-control" required>
                                <option value="">-- Pilih Santri --</option>
                                @foreach (\App\Models\Santri::where('is_active', true)->orderBy('nama')->get() as $santri)
                                    <option value="{{ $santri->id }}">{{ $santri->nama }} ({{ $santri->kamar }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tujuan_kunjungan">Tujuan Kunjungan:</label>
                            <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan (opsional):</label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Daftarkan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
