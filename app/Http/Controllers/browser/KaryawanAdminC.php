<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\DepartemenM;
use App\Models\KaryawanM;
use App\Models\PresensiM;
use DB;
use Hash;
use Illuminate\Http\Request;
use Storage;

class KaryawanAdminC extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Data Karyawan',
        ];
        return view('browser.karyawan', $data);
    }
    public function get_api_karyawan(Request $request)
    {
        $search = $request->search;

        if (isset($search)) {
            $leader = KaryawanM::where('nama', 'LIKE', '%' . $search . '%')->get();
        } else {
            $leader = KaryawanM::all();
        }
        return json_encode($leader);
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
                $imagePath = $request->file('foto')->storeAs('foto', $originalName, 'public');
            }
            $passhas = Hash::make($request->password);
            $attributes = [
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_hp' => $request->no_hp,
                'pass_text' => $request->password,
                'password' => $passhas,
                'kode_dpt' => $request->kode_dpt,
            ];
            if ($imagePath) {
                $attributes['foto'] = $imagePath;
            }
            KaryawanM::updateOrCreate(
                ['id_karyawan' => $request->id_karyawan],
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
        $id_karyawan = $request->input('id');
        $foto = $request->input('foto');

        DB::beginTransaction();
        try {
            if (Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }
            KaryawanM::destroy($id_karyawan);
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
