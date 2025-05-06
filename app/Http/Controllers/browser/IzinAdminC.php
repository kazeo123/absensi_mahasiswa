<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\DepartemenM;
use App\Models\IzinM;
use App\Models\KaryawanM;
use App\Models\PresensiM;
use DB;
use Illuminate\Http\Request;

class IzinAdminC extends Controller
{
    public function index()
    {
        $karyawan = KaryawanM::all();
        $data = [
            'title' => 'Data Izin',
            'karyawan' => $karyawan,
        ];
        return view('browser.izin', $data);
    }

    public function get_api_izin(Request $request)
    {
        $nik = $request->nik;
        $dari = $request->dari;
        $sampai = $request->sampai;


        if (isset($nik)) {
            $leader = IzinM::join('karyawan', 'izin.nik', '=', 'karyawan.nik')
                ->where('izin.nik', $nik)
                ->where('izin.tgl_izin', '>=', $dari)
                ->where('izin.tgl_izin', '<=', $sampai)
                ->get();
        } else {
            if ($request->link == 'home') {
                $leader = IzinM::all();
            } else {
                $leader = IzinM::join('karyawan', 'izin.nik', '=', 'karyawan.nik')->get();
            }
        }
        return json_encode($leader);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $attributes = [
                'status_approv' => $request->status_approv
            ];

            IzinM::updateOrCreate(
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
}
