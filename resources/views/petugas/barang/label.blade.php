<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Barang - {{ $barang->kode_barang }}</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .label-container {
            width: 300px;
            border: 1px solid #000;
            padding: 10px;
            margin: 20px auto;
        }

        .label-header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .label-data {
            margin-bottom: 5px;
        }

        .label-data strong {
            display: inline-block;
            width: 100px;
        }

        .label-qr {
            text-align: center;
            margin: 10px 0;
        }

        .print-btn {
            text-align: center;
            margin: 20px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="label-container">
        <div class="label-header">
            <h4>PONDOK PESANTREN SALAFIYAH AL-JAWAHIR</h4>
            <h5>LABEL BARANG</h5>
        </div>

        <div class="label-data">
            <strong>Kode Barang:</strong> {{ $barang->kode_barang }}
        </div>

        <div class="label-data">
            <strong>Nama Barang:</strong> {{ $barang->nama_barang }}
        </div>

        <div class="label-data">
            <strong>Jumlah:</strong> {{ $barang->jumlah }}
        </div>

        <div class="label-data">
            <strong>Santri:</strong> {{ $barang->kunjungan->santri->nama }}
        </div>

        <div class="label-data">
            <strong>Wali:</strong> {{ $barang->kunjungan->waliSantri->nama }}
        </div>

        <div class="label-data">
            <strong>Tanggal:</strong>
            {{ \Carbon\Carbon::parse($barang->kunjungan->tanggal_kunjungan)->format('d/m/Y') }}
        </div>

        <div class="label-qr">
            {!! QrCode::size(150)->generate($barang->kode_barang) !!}
        </div>
    </div>

    <div class="print-btn">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Label
        </button>
        <a href="{{ route('petugas.barang.show', $barang->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</body>

</html>
