<?php

use App\Http\Controllers\AuthC;
use App\Http\Controllers\browser\AuthAdminC;
use App\Http\Controllers\browser\DashboardAdminC;
use App\Http\Controllers\browser\DepartementAdminC;
use App\Http\Controllers\browser\IzinAdminC;
use App\Http\Controllers\browser\KaryawanAdminC;
use App\Http\Controllers\browser\MonitoringAdminC;
use App\Http\Controllers\browser\ProfilAdminC;
use App\Http\Controllers\browser\UserAdminC;
use App\Http\Controllers\Coba;
use App\Http\Controllers\mobile\DashboardC;
use App\Http\Controllers\mobile\IzinC;
use App\Http\Controllers\mobile\PresensiC;
use App\Http\Controllers\mobile\ProfilC;
use Illuminate\Support\Facades\Route;




Route::get('/coba', [Coba::class, 'index']);
Route::get('/login_admin', [AuthAdminC::class, 'index']);
Route::post('/login_admin', [AuthAdminC::class, 'login_admin']);
Route::get('/logout', [AuthAdminC::class, 'logout']);

Route::get('/login_user', [AuthC::class, 'index']);
Route::get('/logout_user', [AuthC::class, 'logout']);
Route::post('/login_user', [AuthC::class, 'login_user']);


Route::group(['prefix' => 'api'], function () {
    Route::post('/get_dpt', [DepartementAdminC::class, 'get_api_dpt']);
    Route::post('/get_karyawan', [KaryawanAdminC::class, 'get_api_karyawan']);
    Route::post('/get_profil', [ProfilAdminC::class, 'get_api_profil']);
    Route::post('/get_izin', [IzinAdminC::class, 'get_api_izin']);
    Route::post('/get_user', [UserAdminC::class, 'get_api_user']);

});



Route::middleware(['middle_admin'])->group(function () {
    Route::get('/dashboard_admin', [DashboardAdminC::class, 'index']);

    Route::post('/store_karyawan', [KaryawanAdminC::class, 'store']);
    Route::post('/hapus_karyawan', [KaryawanAdminC::class, 'destroy']);
    Route::get('/karyawan', [KaryawanAdminC::class, 'index']);

    Route::post('/store_dpt', [DepartementAdminC::class, 'store']);
    Route::post('/hapus_dpt', [DepartementAdminC::class, 'destroy']);

    Route::get('/departemen', [DepartementAdminC::class, 'index']);
    Route::get('/laporan_presensi', [DashboardAdminC::class, 'presensi']);
    Route::get('/cetak_presensi', [DashboardAdminC::class, 'cetak_presensi']);

    Route::get('/aprove_izin', [IzinAdminC::class, 'index']);
    Route::post('/store_approv', [IzinAdminC::class, 'store']);

    Route::get('/user', [UserAdminC::class, 'index']);
    Route::post('/store_user', [UserAdminC::class, 'store']);

    Route::get('/rekap_presensi', [DashboardAdminC::class, 'rekap_presensi']);
    Route::get('/cetak_rekap_presensi', [DashboardAdminC::class, 'cetak_rekap_presensi']);

    Route::post('/monitor_absen', [MonitoringAdminC::class, 'get_monitoring']);
    Route::get('/monitoring', [MonitoringAdminC::class, 'index']);

    Route::post('/store_profil', [ProfilAdminC::class, 'store']);
    Route::get('/profil_perusahaan', [ProfilAdminC::class, 'index']);
});
Route::middleware(['middleware'])->group(function () {
    Route::get('/dashboard', [DashboardC::class, 'index']);
    Route::get('/presensi', [PresensiC::class, 'index']);
    Route::post('/buat_absen', [PresensiC::class, 'store']);
    Route::get('/profil', [ProfilC::class, 'index']);
    Route::get('/histori', [PresensiC::class, 'histori']);
    Route::get('/izin', [IzinC::class, 'index']);
    Route::post('/get_izin', [IzinC::class, 'get_izin']);
    Route::post('/store_izin', [IzinC::class, 'store']);
    Route::post('/get_histori', [PresensiC::class, 'get_histori_presensi']);
    Route::post('/update_profil', [ProfilC::class, 'store']);
});
