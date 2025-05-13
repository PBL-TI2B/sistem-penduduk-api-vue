<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Penduduk;
use App\Models\AnggotaKeluarga;
use App\Models\Kelahiran;
use App\Models\Kematian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function statistikDemografi()
    {
        $total = Penduduk::where('status', 'hidup')->count();
        $laki = Penduduk::where('jenis_kelamin', 'L')->where('status', 'hidup')->count();
        $perempuan = Penduduk::where('jenis_kelamin', 'P')->where('status', 'hidup')->count();

        $kk = AnggotaKeluarga::whereHas('statusKeluarga', function($q){
            $q->where('status_keluarga_id', 1);
        })->whereHas('penduduk', function($q){
            $q->where('status', 'hidup');
        })->count();

        return response()->json([
            'success' => true,
            'message' => 'Statistik demografi',
            'data' => [
                'total_penduduk' => $total,
                'jumlah_laki_laki' => $laki,
                'jumlah_perempuan' => $perempuan,
                'jumlah_kepala_keluarga' => $kk
            ]
        ]);
    }

    public function statistikPendidikan()
    {
        $data = Penduduk::select('pendidikan_id')
            ->selectRaw('COUNT(*) as jumlah')
            ->with('pendidikan:id,jenjang')
            ->groupBy('pendidikan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'pendidikan' => $item->pendidikan->jenjang ?? 'Tidak Diketahui',
                    'jumlah' => $item->jumlah,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Statistik pendidikan penduduk',
            'data' => $data
        ]);
    }

    public function statistikPekerjaan()
    {
        $data = Penduduk::select('pekerjaan_id')
            ->selectRaw('COUNT(*) as jumlah')
            ->with('pekerjaan:id,nama_pekerjaan')
            ->groupBy('pekerjaan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'pekerjaan' => $item->pekerjaan->nama_pekerjaan ?? 'Tidak Diketahui',
                    'jumlah' => $item->jumlah,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Statistik pekerjaan penduduk',
            'data' => $data,
        ]);
    }

    public function statistikAgama()
    {
        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'];

        // Ambil data dari DB
        $data = Penduduk::select('agama')
            ->selectRaw('COUNT(*) as jumlah')
            ->groupBy('agama')
            ->pluck('jumlah', 'agama') // hasilnya jadi key-value: ['Islam' => 100, dst]
            ->toArray();

        // Buat array lengkap 6 agama
        $result = [];
        foreach ($agamas as $agama) {
            $result[] = [
                'agama' => $agama,
                'jumlah' => $data[$agama] ?? 0, // default 0 kalau tidak ditemukan
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Statistik agama penduduk',
            'data' => $result,
        ]);
    }
    
    public function statistikUmur()
    {
        $ranges = [
            '0-5' => [0, 5],
            '6-10' => [6, 10],
            '11-15' => [11, 15],
            '16-20' => [16, 20],
            '21-25' => [21, 25],
            '26-30' => [26, 30],
            '31-35' => [31, 35],
            '36-40' => [36, 40],
            '41-45' => [41, 45],
            '46-50' => [46, 50],
            '51-55' => [51, 55],
            '56-60' => [56, 60],
            '61-65' => [61, 65],
            '66-70' => [66, 70],
            '71-75' => [71, 75],
            '76-80' => [76, 80],
            '81-85' => [81, 85],
            '86+'   => [86, 200], // 200 biar aman
        ];

        $data = [];

        foreach ($ranges as $label => [$min, $max]) {
            $laki = Penduduk::where('jenis_kelamin', 'L')
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max])
                ->count();

            $perempuan = Penduduk::where('jenis_kelamin', 'P')
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max])
                ->count();

            $data[] = [
                'umur' => $label,
                'L' => $laki,
                'P' => $perempuan,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Statistik umur penduduk',
            'data' => $data,
        ]);
    }

    public function statistikKematian()
    {
        $tahun = request('tahun', now()->year); // default tahun sekarang
        $data = Kematian::selectRaw('YEAR(tanggal_kematian) as tahun, MONTH(tanggal_kematian) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_kematian', $tahun)
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        return response()->json([
            'success' => true,
            'message' => "Statistik kematian tahun $tahun",
            'data' => $data
        ]);
    }

    public function statistikKelahiran()
    {
        $tahun = request('tahun', now()->year); // default tahun sekarang
        $data = Kelahiran::selectRaw('YEAR(waktu_kelahiran) as tahun, MONTH(waktu_kelahiran) as bulan, COUNT(*) as jumlah')
            ->whereYear('waktu_kelahiran', $tahun)
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        return response()->json([
            'success' => true,
            'message' => "Statistik kelahiran tahun $tahun",
            'data' => $data
        ]);
    }

}
