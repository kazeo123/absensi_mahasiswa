<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\PresensiM;
use App\Models\ProfilM;
use Auth;
use DB;
use Illuminate\Http\Request;
use Storage;
use Str;

class PresensiC extends Controller
{
    public function index()
    {
        $tgl_hariini = date('d-m-Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('nik', $nik)->where('tgl', $tgl_hariini)->count();
        $lokasi = ProfilM::first();
        $foto = Auth::guard('karyawan')->user()->foto;
        $data = [
            'title' => 'Presensi',
            'cek' => $cek,
            'foto' => $foto,
            'lokasi' => $lokasi,
        ];
        return view('mobile.presensi', $data);
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl = date('d-m-Y');
        $jam = date('H:i:s');
        $lokasi = $request->lokasi;
        $image = $request->image;
        $lokasiUser = explode(",", $lokasi);
        $lokasi = ProfilM::first();
        $latitudekantor = explode(',', $lokasi->lokasi)[0];
        $longitudekantor = explode(',', $lokasi->lokasi)[1];
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);
        $formatName = Str::slug($nik . "_" . $tgl . "_" . $jam);
        $patch = "upload/presensi/" . $formatName;

        if ($image) {
            $image_patch = explode(";base64,", $image);

            if (isset($image_patch[1])) {
                $image_base64 = base64_decode($image_patch[1]);
            }
        }


        $fielName = $formatName . ".png";

        $file = $patch . $fielName;

        $data = [
            'nik' => $nik,
            'tgl' => $tgl,
            'jam_in' => $jam,
            'lokasi' => $lokasi,
            'foto_in' => $file
        ];
        $cek = DB::table('presensi')->where('nik', $nik)->where('tgl', $tgl)->count();

        if ($radius > $lokasi->area) {
            $response = [
                'status' => 'gagal',
                'message' => 'Maaf anda berada di luar radius, jarak anda ' . $radius . ' meter dari kantor ',
                'status_absen' => 'out'
            ];
            return response()->json($response);
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $file,
                    'lokasi_pulang' => $lokasi
                ];
                $update = DB::table('presensi')->where('nik', $nik)->where('tgl', $tgl)->update($data_pulang);
                if ($update) {
                    Storage::disk('public')->put($file, $image_base64);
                    $response = [
                        'status' => 'success',
                        'message' => 'Absensi Pulang Berhasil,Selamat Pulang Kembali',
                        'status_absen' => 'out'
                    ];
                    return response()->json($response);
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Presensi Gagal, Silahkan hubungi IT'
                    ];
                    return response()->json($response);
                }
            } else {
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    Storage::disk('public')->put($file, $image_base64);
                    $response = [
                        'status' => 'success',
                        'message' => 'Absensi Masuk Berhasil, Selamat Bekerja',
                        'status_absen' => 'in'
                    ];
                    return response()->json($response);
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Presensi Gagal, Silahkan hubungi IT'
                    ];
                    return response()->json($response);
                }
            }
        }

    }

    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }


    function histori()
    {
        $bulan = [
            ["id" => 1, "nama" => "Januari"],
            ["id" => 2, "nama" => "Februari"],
            ["id" => 3, "nama" => "Maret"],
            ["id" => 4, "nama" => "April"],
            ["id" => 5, "nama" => "Mei"],
            ["id" => 6, "nama" => "Juni"],
            ["id" => 7, "nama" => "Juli"],
            ["id" => 8, "nama" => "Agustus"],
            ["id" => 9, "nama" => "September"],
            ["id" => 10, "nama" => "Oktober"],
            ["id" => 11, "nama" => "November"],
            ["id" => 12, "nama" => "Desember"]
        ];
        $tahun = DB::table('presensi')
            ->selectRaw('YEAR(STR_TO_DATE(tgl, "%d-%m-%Y")) as tahun')
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->get();
        $data = [
            'title' => 'Histori Presensi',
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        return view('mobile.histori', $data);
    }

    public function get_histori_presensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        if (isset($bulan) || isset($tahun)) {
            $histori = PresensiM::where('presensi.nik', $nik)
                ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
                ->whereRaw("MONTH(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$bulan])
                ->whereRaw("YEAR(STR_TO_DATE(tgl, '%d-%m-%Y')) = ?", [$tahun])
                ->get();
        } else {
            $histori = PresensiM::where('presensi.nik', $nik)->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')->get();

        }
        return json_encode($histori);
    }

}
