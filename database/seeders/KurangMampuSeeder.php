<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KurangMampuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kurang_mampu')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'anggota_keluarga_id' => 1,
                'pendapatan_per_hari' => 100000,
                'pendapatan_per_bulan' => 3000000,
                'jumlah_tanggungan' => 3,
                'status_validasi' => 'tervalidasi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
