<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Gaji Bulanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background: #eee;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Laporan Gaji Bulanan</h2>
    <p>Periode: {{ $bulan }}/{{ $tahun }}</p>

    <table>
        <tr>
            <th>Jumlah Pegawai</th>
            <th>Total Lembur</th>
            <th>Total Potongan</th>
        </tr>
        <tr>
            <td>{{ $jumlah_pegawai }}</td>
            <td>Rp {{ number_format($total_lembur, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($total_potongan, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h3>Rekap Gaji Bulanan</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pegawai</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Total Potongan</th>
                <th>Total Lembur</th>
                <th>Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap_gaji as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['jabatan'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['gaji_pokok'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total_potongan'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total_lembur'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['gaji_bersih'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
