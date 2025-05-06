<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Paper.css for printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Custom Styles -->
    <style>
        @page {
            size: A4 landscape;

        }

        .sheet {
            width: 297mm;
            height: 210mm;
            padding: 10mm;
        }

        .presensi {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .presensi th,
        .presensi td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .presensi th {
            background-color: #b6b6b6;
        }
    </style>
</head>

<body class="A4 landscape">
    <section class="sheet">
        <table>
            <tr>
                <td><img src="/icon.png" width="80" alt=""></td>
                <td><b style="font-size: 20px;">LAPORAN PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper(\Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F')) }}
                        {{ $tahun }}</b><br>
                    Jln. H. Dahlan
                </td>
            </tr>
        </table>
        <br>

        <table class="presensi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    @for ($i = 1; $i <= $jumlah_hari; $i++) <th>{{ $i }}</th>
                        @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->nama }}</td>

                    @for ($i = 1; $i <= $jumlah_hari; $i++) @php $tanggal=str_pad($i, 2, '0' , STR_PAD_LEFT) . '-' .
                        str_pad($bulan, 2, '0' , STR_PAD_LEFT) . '-' . $tahun; $presensi=$histori->where('nik',
                        $item->nik)->firstWhere('tgl', $tanggal);
                        @endphp
                        <td>
                            @if ($presensi)
                            <div>{{ $presensi->jam_in }} - {{ $presensi->jam_out ?? 'Belum Absen' }}</div>
                            @else
                            <div style="text-align: center;">-</div>
                            @endif
                        </td>
                        @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>

</html>
