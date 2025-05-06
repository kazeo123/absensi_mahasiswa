<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\KaryawanM;
use App\Models\PresensiM;
use DB;
use Illuminate\Http\Request;

class DashboardAdminC extends Controller
{
    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $tgl_hariini = date('d-m-Y');
        $histori = PresensiM::whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
            ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
            ->get();
        $presensi = PresensiM::where('tgl', $tgl_hariini)->first();
        $rekapizin = DB::table('izin')->selectRaw('SUM(IF(status="izin",1,0)) as jmlizin, SUM(IF(status="sakit",1,0)) as jmlsakit, SUM(IF(status="cuti",1,0)) as jmlcuti')
            ->whereRaw("MONTH(tgl_izin) = ?", [$bulan])
            ->whereRaw("YEAR(tgl_izin) = ?", [$tahun])
            ->first();

        $namabulan = [
            1 => "Januari",
            2 => "Februari",
            3 => "Maret",
            4 => "April",
            5 => "Mei",
            6 => "Juni",
            7 => "Juli",
            8 => "Agustus",
            9 => "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember"
        ];
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
            ->whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
            ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
            ->first();
        $leaderBoard = DB::table('presensi')->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl', $tgl_hariini)
            ->orderBy('jam_in', 'desc')
            ->get();
        $data = [
            'title' => 'Dashboard Presensi',
            'presensi' => $presensi,
            'histori' => $histori,
            'namabulan' => $namabulan[date('n')],
            'rekappresensi' => $rekappresensi,
            'leaderboard' => $leaderBoard,
            'rekapizin' => $rekapizin
        ];
        return view('browser.dashboard', $data);
    }

    public function presensi()
    {
        $bulan = [
            ["id" => 1, "nama" => "Januari"],
            ["id" => 2, "nama" => "Februari"],
            ["id" => 3, "nama" => "Maret"],
            ["id" => 4, "nama" => "April"],
            ["id" => 5, "nama" => "Mei"],
            ["id" => 6, "nama" => "Juni"],
            ["id" => 7, "nama" => "Juli"],
            ["id" => 8, "nama" => "Agustus"],
            ["id" => 9, "nama" => "September"],
            ["id" => 10, "nama" => "Oktober"],
            ["id" => 11, "nama" => "November"],
            ["id" => 12, "nama" => "Desember"]
        ];
        $tahun = PresensiM::selectRaw('YEAR(STR_TO_DATE(tgl, "%d-%m-%Y")) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get();
        $karyawan = KaryawanM::all();
        $data = [
            'title' => 'Laporan Presensi',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'karyawan' => $karyawan
        ];
        return view('browser.report.presensi.index', $data);
    }
    public function cetak_presensi(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = $request->nik;
        $karyawan = KaryawanM::where('nik', $nik)->join('departement', 'karyawan.kode_dpt', '=', 'departement.kode')->first();
        $histori = PresensiM::whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
            ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
            ->whereRaw("nik = ?", [$nik])
            ->get();

        foreach ($histori as $item) {
            $terlambat = $this->selisih('07:00:00', $item->jam_in);

            // Berikan default "00:00:00" jika jam_out kosong
            $item->jam_out = !empty($item->jam_out) ? $item->jam_out : "00:00:00";

            $jml_jam = $this->selisih($item->jam_in, $item->jam_out);

            if ($item->jam_in > '07:00') {
                $item->ket = 'Terlambat (' . $terlambat . ')';
            } else {
                $item->ket = 'Tepat Waktu';
            }

            $item->jml_jam = $jml_jam;
        }

        $data = [
            'title' => 'Cetak Presensi',
            'karyawan' => $karyawan,
            'histori' => $histori,
        ];
        return view('browser.report.presensi.cetak', $data);
    }
    public function rekap_presensi()
    {
        $bulan = [
            ["id" => 1, "nama" => "Januari"],
            ["id" => 2, "nama" => "Februari"],
            ["id" => 3, "nama" => "Maret"],
            ["id" => 4, "nama" => "April"],
            ["id" => 5, "nama" => "Mei"],
            ["id" => 6, "nama" => "Juni"],
            ["id" => 7, "nama" => "Juli"],
            ["id" => 8, "nama" => "Agustus"],
            ["id" => 9, "nama" => "September"],
            ["id" => 10, "nama" => "Oktober"],
            ["id" => 11, "nama" => "November"],
            ["id" => 12, "nama" => "Desember"]
        ];
        $tahun = PresensiM::selectRaw('YEAR(STR_TO_DATE(tgl, "%d-%m-%Y")) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get();
        $data = [
            'title' => 'Laporan Rekap Presensi',
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        return view('browser.report.presensi.rekap', $data);
    }


    public function cetak_rekap_presensi(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $karyawan = KaryawanM::join('departement', 'karyawan.kode_dpt', '=', 'departement.kode')->get();
        $histori = PresensiM::selectRaw("*, CONCAT(jam_in, ' - ', IFNULL(jam_out, '-')) as jam_presensi")
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->join('departement', 'karyawan.kode_dpt', '=', 'departement.kode')
            ->whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
            ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
            ->get();

        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $data = [
            'title' => 'Cetak Presensi',
            'karyawan' => $karyawan,
            'histori' => $histori,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlah_hari' => $jumlah_hari,
        ];
        return view('browser.report.presensi.cetak_rekap_presensi', $data);
    }
    private function selisih($jam_masuk, $jam_keluar)
    {
        list($h, $m, $s) = explode(":", $jam_masuk);
        $dtAwal = mktime($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(":", $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode(".", $totalmenit / 60);
        $sisamenit = ($totalmenit / 60) - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        return $jam[0] . ":" . round($sisamenit2);
    }
}
