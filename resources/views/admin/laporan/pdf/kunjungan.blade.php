<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>APLIKASI KUNJUNGAN SANTRI</h2>
        <p>Jl. Contoh No. 123, Kota, Indonesia</p>
        <p>Telp: (021) 1234567</p>
    </div>

    <h1>Laporan Data Kunjungan</h1>
    <p>Periode: {{ isset($tanggal_awal) ? date('d/m/Y', strtotime($tanggal_awal)) : '' }} -
        {{ isset($tanggal_akhir) ? date('d/m/Y', strtotime($tanggal_akhir)) : date('d/m/Y') }}</p>

    <table>
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
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Data tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Bandung, {{ date('d F Y') }}</p>
        <br><br><br>
        <p>Admin</p>
    </div>
</body>

</html>
