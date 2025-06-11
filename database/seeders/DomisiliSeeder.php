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
        DB::table('domisili')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'rt_id' => 1,
                'penduduk_id' => 1,
                'status_tempat_tinggal' => 'tetap',
                'alamat_asal' => null,
                'alamat_saat_ini' => 'Jl. Contoh Alamat Saat Ini No. 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
