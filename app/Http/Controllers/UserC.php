<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserC extends Controller
{
    public function registerFace(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'face_encoding' => $request->face_encoding,
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    public function getFaceEncodings()
    {
        $users = User::select('id', 'name', 'face_encoding')->get();
        return response()->json($users);
    }
}
