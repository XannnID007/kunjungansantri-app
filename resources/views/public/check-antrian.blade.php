<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kunjungan</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 20px;
        }

        .header {
            background-color: #3498db;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .status-box {
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: white;
        }

        .status-pending {
            background-color: #f39c12;
        }

        .status-confirmed {
            background-color: #3498db;
        }

        .status-checked_in {
            background-color: #9b59b6;
        }

        .status-in_progress {
            background-color: #2ecc71;
        }

        .status-completed {
            background-color: #7f8c8d;
        }

        .status-cancelled {
            background-color: #e74c3c;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>INFORMASI KUNJUNGAN SANTRI</h1>
            <h3>Pondok Pesantren Salafiyah Al-Jawahir</h3>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Detail Kunjungan: {{ $kunjungan->kode_kunjungan }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="status-box status-{{ $kunjungan->status }}">
                            <h3 class="text-center">STATUS KUNJUNGAN: {{ strtoupper($kunjungan->status) }}</h3>
                            <h4 class="text-center mt-2">NOMOR ANTRIAN: {{ $kunjungan->nomor_antrian }}</h4>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Informasi Santri</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nama:</strong> {{ $kunjungan->santri->nama }}</p>
                                        <p><strong>Kamar:</strong> {{ $kunjungan->santri->kamar }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Informasi Wali</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nama:</strong> {{ $kunjungan->waliSantri->nama }}</p>
                                        <p><strong>Hubungan:</strong> {{ $kunjungan->waliSantri->hubungan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Jadwal Kunjungan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Tanggal:</strong>
                                            {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </p>
                                        <p><strong>Jam:</strong>
                                            {{ \Carbon\Carbon::parse($kunjungan->jam_kunjungan)->format('H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tujuan:</strong> {{ $kunjungan->tujuan_kunjungan }}</p>
                                        @if (in_array($kunjungan->status, ['pending', 'confirmed', 'checked_in']))
                                            <p><strong>Estimasi Waktu Tunggu:</strong> {{ $estimasi_tunggu }} menit</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($kunjungan->barang->count() > 0)
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Daftar Barang</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Deskripsi</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kunjungan->barang as $barang)
                                                    <tr>
                                                        <td>{{ $barang->nama_barang }}</td>
                                                        <td>{{ $barang->jumlah }}</td>
                                                        <td>{{ $barang->deskripsi ?? '-' }}</td>
                                                        <td>{!! $barang->status_label !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="qr-code">
                            <p><strong>Tunjukkan QR Code ini saat kunjungan:</strong></p>
                            <img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl={{ $kunjungan->kode_kunjungan }}"
                                alt="QR Code">
                        </div>

                        <div class="back-btn">
                            <a href="{{ route('display-antrian') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Display Antrian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
