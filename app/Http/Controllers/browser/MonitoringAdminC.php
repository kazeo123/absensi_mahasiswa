<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\DepartemenM;
use App\Models\PresensiM;
use DB;
use Illuminate\Http\Request;

class MonitoringAdminC extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Monitoring Absensi',

        ];
        return view('browser.monitoring', $data);
    }

    public function get_monitoring(Request $request)
    {
        $tanggal = date('d-m-Y', strtotime($request->tanggal));
        if (isset($tanggal)) {
            $monitor = PresensiM::where('tgl', $tanggal)->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')->join('departement', 'karyawan.kode_dpt', '=', 'departement.kode')->get();
        } else {
            $monitor = PresensiM::all();
        }
        return json_encode($monitor);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {


            $attributes = [
                'kode' => $request->kode,
                'departemen' => $request->departemen
            ];

            DepartemenM::updateOrCreate(
                ['id' => $request->id],
                $attributes
            );
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Disimpan'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 'gagal',
                'message' => 'Data Gagal Disimpan'
            ];
        }
        return $response;
    }
    public function destroy(Request $request)
    {
        $id_dpt = $request->input('id');

        DB::beginTransaction();
        try {

            DepartemenM::destroy($id_dpt);
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 'gagal',
                'message' => 'Data Gagal Dihapus'
            ];
        }
        return $response;
    }

    function selisih($jam_masuk, $jam_keluar)
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
        $jml_jam = $jam[0];
        return $jml_jam . ":" . round($sisamenit2);
    }
}
