<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use App\Models\DepartemenM;
use App\Models\PresensiM;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;

class UserAdminC extends Controller
{
    public function index()
    {
        // $id_user = auth()->user()->id_user;
        $data = [
            "title" => "Data User",
            // 'menu' => PengaturanAksesM::with('menu:id,menu,icon,link')->where('id_user', $id_user)->get(),

        ];
        return view("browser.user", $data);
    }
    public function get_api_user(Request $request)
    {
        $search = $request->search;

        if (isset($search)) {
            $user = User::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $user = User::all();
        }
        return json_encode($user);
    }
    // public function get_api_pengaturan_akses(Request $request)
    // {
    //     $id = $request->id;
    //     $user = PengaturanAksesM::with('menu:id,menu')->where('id_user', $id)->get();

    //     return json_encode($user);
    // }

    public function store(Request $request)
    {


        DB::beginTransaction();
        try {

            if ($request->id == null) {
                $passhas = Hash::make($request->password);
                $attributes = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password_text' => $request->password,
                    'status' => $request->status,
                    'password' => $passhas,
                ];
            } else {
                if ($request->password == null) {
                    $attributes = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'status' => $request->status,

                    ];
                } else {
                    $passhas = Hash::make($request->password);
                    $attributes = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'status' => $request->status,
                        'password_text' => $request->password,
                        'password' => $passhas,
                    ];
                }
            }


            User::updateOrCreate(
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
    public function store_akses_user(Request $request)
    {
        DB::beginTransaction();
        try {
            $id_menu = $request->id_menu;

            foreach ($id_menu as $key => $value) {
                $data = [
                    'id_menu' => $value,
                    'id_user' => $request->id_user,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                PengaturanAksesM::insert(
                    $data
                );
            }

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
        $id_user = $request->input('id');
        $gambar = $request->input('gambar');
        DB::beginTransaction();
        try {
            if (Storage::disk('public')->exists($gambar)) {
                Storage::disk('public')->delete($gambar);
            }
            UserM::destroy($id_user);
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
    public function destroy_akses(Request $request)
    {
        $id_akses = $request->input('id_akses');
        DB::beginTransaction();
        try {
            PengaturanAksesM::destroy($id_akses);
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
