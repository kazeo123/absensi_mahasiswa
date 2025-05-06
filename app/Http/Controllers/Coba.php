<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class Coba extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Halaman Login'
        ];
        return view('camera', $data);
    }


    public function login_user(Request $request)
    {

        if (Auth::guard('karyawan')->attempt(['nik' => $request->username, 'password' => $request->password])) {
            $user = Auth::guard('karyawan')->user();
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login berhasil',
                'status' => 200,
                'user' => [
                    'id' => $user->id_karyawan,
                    'nik' => $user->nik,
                    'nama' => $user->nama,
                ],
            ]);
        }

        return response()->json([
            'message' => 'Password atau Username salah',
            'status' => 401,
        ], 401);

    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login_user')->with('status', 'Logout berhasil');
    }
}
