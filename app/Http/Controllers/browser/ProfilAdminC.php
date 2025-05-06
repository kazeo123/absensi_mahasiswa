<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\DepartemenM;
use App\Models\ProfilM;
use DB;
use Illuminate\Http\Request;
use Storage;

class ProfilAdminC extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Profil Perusahaan',

        ];
        return view('browser.profil', $data);
    }

    public function get_api_profil(Request $request)
    {

        $profil = ProfilM::first();
        return json_encode($profil);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $imagePath = null;
            $imagePath1 = null;
            if ($request->hasFile('logo')) {
                if ($request->oldImage && Storage::disk('public')->exists($request->oldImage)) {

                    Storage::disk('public')->delete($request->oldImage);
                }
                $originalName = $request->file('logo')->getClientOriginalName();
                $imagePath = $request->file('logo')->storeAs('profil_perusahaan', $originalName, 'public');
            }
            if ($request->hasFile('favicon')) {
                if ($request->oldImageFav && Storage::disk('public')->exists($request->oldImageFav)) {
                    Storage::disk('public')->delete($request->oldImageFav);
                }
                $originalName = $request->file('favicon')->getClientOriginalName();
                $imagePath1 = $request->file('favicon')->storeAs('profil_perusahaan', $originalName, 'public');
            }
            $attributes = [
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'area' => $request->area,
                'lokasi' => $request->lokasi
            ];
            if ($imagePath) {
                $attributes['logo'] = $imagePath;
            }
            if ($imagePath1) {
                $attributes['favicon'] = $imagePath1;
            }
            ProfilM::updateOrCreate(
                ['id' => $request->id],
                $attributes
            );
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Diupdate'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 'gagal',
                'message' => 'Data Gagal Diupdate'
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
