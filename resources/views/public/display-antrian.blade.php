<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30"> <!-- Auto refresh setiap 30 detik -->
    <title>Display Antrian Kunjungan</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .display-container {
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

        .current-box {
            background-color: #2ecc71;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .queue-box {
            background-color: #f39c12;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .time-box {
            background-color: #34495e;
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #3498db;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container display-container">
        <div class="header">
            <h1>SISTEM ANTRIAN KUNJUNGAN SANTRI</h1>
            <h3>Pondok Pesantren Salafiyah Al-Jawahir</h3>
            <h4>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</h4>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="time-box">
                    <h2>WAKTU SAAT INI</h2>
                    <div id="current-time">{{ \Carbon\Carbon::now()->format('H:i:s') }}</div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">KUNJUNGAN SAAT INI</h3>
                    </div>
                    <div class="card-body">
                        @if ($current_kunjungan->count() > 0)
                            @foreach ($current_kunjungan as $kunjungan)
                                <div class="current-box">
                                    <h1 class="text-center">NOMOR ANTRIAN: {{ $kunjungan->nomor_antrian }}</h1>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <h5>SANTRI:</h5>
                                            <h3>{{ $kunjungan->santri->nama }}</h3>
                                            <p>{{ $kunjungan->santri->kamar }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>WALI:</h5>
                                            <h3>{{ $kunjungan->waliSantri->nama }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <h4 class="text-center">Tidak ada kunjungan yang sedang berlangsung saat ini</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h3 class="mb-0">ANTRIAN BERIKUTNYA</h3>
                    </div>
                    <div class="card-body">
                        @if ($next_kunjungan->count() > 0)
                            @foreach ($next_kunjungan as $kunjungan)
                                <div class="queue-box">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h1 class="text-center">{{ $kunjungan->nomor_antrian }}</h1>
                                        </div>
                                        <div class="col-md-9">
                                            <h4>{{ $kunjungan->santri->nama }} ({{ $kunjungan->santri->kamar }})</h4>
                                            <p>Wali: {{ $kunjungan->waliSantri->nama }}</p>
                                            <p>Jam:
                                                {{ \Carbon\Carbon::parse($kunjungan->jam_kunjungan)->format('H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <h4 class="text-center">Tidak ada antrian berikutnya</h4>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0">CEK KUNJUNGAN</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('check-antrian', 'kode') }}" method="GET" id="check-form">
                            <div class="form-group">
                                <label for="kode_kunjungan">Masukkan Kode Kunjungan:</label>
                                <div class="input-group">
                                    <input type="text" name="kode" id="kode_kunjungan" class="form-control"
                                        placeholder="Contoh: KJG-ABC123">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Cek Antrian</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>Perhatian:</strong> Harap pantau nomor antrian Anda. Nomor antrian yang tidak hadir saat
                dipanggil akan dibatalkan.</p>
        </div>
    </div>

    <script src="{{ asset('template/assets/js/jquery.min.js') }}"></script>
    <script>
        // Update waktu saat ini setiap detik
        setInterval(function() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0') + ':' +
                now.getSeconds().toString().padStart(2, '0');
            document.getElementById('current-time').textContent = timeString;
        }, 1000);

        // Submit form dengan kode kunjungan yang benar
        document.getElementById('check-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const kode = document.getElementById('kode_kunjungan').value.trim();
            if (kode) {
                window.location.href = "{{ url('check-antrian') }}/" + kode;
            }
        });
    </script>
</body>

</html>
