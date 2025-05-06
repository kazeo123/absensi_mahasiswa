<?php

use App\Http\Controllers\AttendanceC;
use App\Http\Controllers\UserC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register-face', [UserC::class, 'registerFace']);
Route::get('/face-encodings', [UserC::class, 'getFaceEncodings']);
