<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\PresensiM;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardC extends Controller
{
    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $tgl_hariini = date('d-m-Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $histori = PresensiM::where('nik', $nik)
            ->whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
            ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
            ->get();
        $presensi = PresensiM::where('nik', $nik)->where('tgl', $tgl_hariini)->first();
        $rekapizin = DB::table('izin')->where('nik', $nik)->selectRaw('SUM(IF(status="izin",1,0)) as jmlizin, SUM(IF(status="sakit",1,0)) as jmlsakit, SUM(IF(status="cuti",1,0)) as jmlcuti')
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
            ->where('nik', $nik)
            ->whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
            ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
            ->first();
        $leaderBoard = DB::table('presensi')->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl', $tgl_hariini)
            ->orderBy('jam_in', 'desc')
            ->get();
        $data = [
            'title' => 'Dashboard',
            'presensi' => $presensi,
            'histori' => $histori,
            'namabulan' => $namabulan[date('n')],
            'rekappresensi' => $rekappresensi,
            'leaderboard' => $leaderBoard,
            'rekapizin' => $rekapizin
        ];
        return view('mobile.dashboard', $data);
    }
}
