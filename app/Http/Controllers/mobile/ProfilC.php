<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\KaryawanM;
use App\Models\PresensiM;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Storage;

class ProfilC extends Controller
{
    public function index()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $profil = KaryawanM::where('nik', $nik)->first();
        $data = [
            'title' => 'Profil',
            'profil' => $profil
        ];
        return view('mobile.profil', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $imagePath = null;
            if ($request->hasFile('foto')) {
                if ($request->oldImage && Storage::disk('public')->exists($request->oldImage)) {

                    Storage::disk('public')->delete($request->oldImage);
                }
                $originalName = $request->file('foto')->getClientOriginalName();
                $imagePath = $request->file('foto')->storeAs('profil', $originalName, 'public');
            }

            if ($request->password != null) {
                $passhas = Hash::make($request->password);

                $attributes = [
                    'nama' => $request->nama_lengkap,
                    'no_hp' => $request->no_hp,
                    'password' => $passhas,
                ];
            } else {
                $attributes = [
                    'nama' => $request->nama_lengkap,
                    'no_hp' => $request->no_hp,
                ];

            }
            if ($imagePath) {
                $attributes['foto'] = $imagePath;
            }
            KaryawanM::updateOrCreate(
                ['id_karyawan' => $request->id],
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
}
