<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\DepartemenM;
use App\Models\PresensiM;
use DB;
use Illuminate\Http\Request;

class DepartementAdminC extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Data Departemen',
        ];
        return view('browser.departemen', $data);
    }

    public function get_api_dpt(Request $request)
    {
        $search = $request->search;

        if (isset($search)) {
            $leader = DepartemenM::where('departemen', 'LIKE', '%' . $search . '%')->get();
        } else {
            if ($request->link == 'home') {
                $leader = DepartemenM::all();
            } else {
                $leader = DepartemenM::all();
            }
        }
        return json_encode($leader);
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
}
