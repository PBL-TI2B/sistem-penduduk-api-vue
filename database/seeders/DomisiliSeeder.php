<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DomisiliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Siapkan array kosong untuk menampung semua data
        $domisiliData = [];

        // Opsi untuk status tempat tinggal yang akan dipilih secara acak
        $statusOptions = ['tetap', 'sementara'];

        // Lakukan perulangan untuk membuat 40 data
        for ($i = 1; $i <= 40; $i++) {
            $domisiliData[] = [
                'id' => $i,
                'uuid' => Str::uuid(),
                // Asumsi ada 5 RT, ID RT akan diacak dari 1-5
                'rt_id' => rand(1, 4),
                // Mengaitkan dengan penduduk_id dari 1 sampai 40
                'penduduk_id' => $i,
                // Memilih status secara acak dari array $statusOptions
                'status_tempat_tinggal' => $statusOptions[array_rand($statusOptions)],
                'alamat_asal' => null,
                // Membuat alamat unik untuk setiap data
                'alamat_saat_ini' => 'Jl. Desa Sejahtera No. ' . $i . ', Dusun Makmur',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Masukkan semua data ke database dalam satu query untuk performa lebih baik
        DB::table('domisili')->insert($domisiliData);
    }
}
