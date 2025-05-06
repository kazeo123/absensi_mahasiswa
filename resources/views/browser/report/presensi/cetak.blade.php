<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        .presensi {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .presensi tr,
        th {
            border: 1px solid #000;
            padding: 5px;
            background-color: #b6b6b6;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table>
            <tr>
                <td><img src="/icon.png" width="80" alt=""></td>
                <td><b style="font-size: 20px;">LAPORAN PRESENSI KARYAWAN<br>
                        PERIODE MARET 2024</b><br>
                    Jln. H. Dahlan
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td rowspan="6" width="120px;"><img src="storage/{{ $karyawan->foto }}" width="100" alt=""></td>
            </tr>
            <tr>
                <td width="100px;">Nik</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $karyawan->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->departemen }}</td>
            </tr>
            <tr>
                <td>No Hp</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="presensi">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nik</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Jml Jam</th>
            </tr>
            <tbody>
                @foreach ($histori as $item)
                <tr style="background-color: #fff">
                    <td style="border:1px solid; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="border:1px solid;">{{ $item->tgl }}</td>
                    <td style="border:1px solid;">{{ $item->nik }}</td>
                    <td style="border:1px solid;">{{ $item->jam_in }}</td>
                    <td style="border:1px solid;"><img src="storage/{{ $item->foto_in }}" width="50" alt=""></td>
                    <td style="border:1px solid;">{{ $item->jam_out == "00:00:00" ? 'Belum Absen' :
                        $item->jam_out }}</td>
                    <td style="border:1px solid;"><img src="storage/{{ $item->foto_out }}" width="50" alt=""></td>
                    <td style="border:1px solid;">{{ $item->ket }}</td>
                    <td style="border:1px solid;">{{ $item->jml_jam }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

</body>

</html>
