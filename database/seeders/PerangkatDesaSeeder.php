<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PerangkatDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perangkat_desa')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penduduk_id' => 1,
                'jabatan_id' => 1,
                'periode_jabatan_id' => 1,
                'status_keaktifan' => 'AKTIF',
                'desa_id'=> 1,
                'dusun_id' => 1,
                'rt_id' => 1,
                'rw_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
