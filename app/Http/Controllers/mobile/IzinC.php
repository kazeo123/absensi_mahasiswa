<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\IzinM;
use App\Models\KaryawanM;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Storage;

class IzinC extends Controller
{
    public function index()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $profil = KaryawanM::where('nik', $nik)->first();
        $data = [
            'title' => 'Izin',
            'profil' => $profil
        ];
        return view('mobile.izin', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $attributes = [
                'nik' => Auth::guard('karyawan')->user()->nik,
                'tgl_izin' => $request->tgl_izin,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
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
    public function get_izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $izin = IzinM::where('nik', $nik)->get();
        return json_encode($izin);
    }
}
