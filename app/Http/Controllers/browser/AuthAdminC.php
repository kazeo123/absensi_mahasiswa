<?php

namespace App\Http\Controllers\browser;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthAdminC extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login Admin',
        ];
        return view('browser.login', $data);
    }
    public function login_admin(Request $request)
    {

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $request->session()->regenerate();
            return response()->json([
                'message' => 'Login berhasil',
                'status' => 200,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
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

        return response()->json([
            'message' => 'Anda Berhasil Logout',
            'status' => 'success',
        ], 200);
    }
}
