<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KartuKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kartu_keluarga')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nomor_kk' => '1234567890123456',
                'rt_id' => 1,
                'kode_pos' => '12345',
                'kelurahan' => 'Kelurahan',
                'kecamatan' => 'Kecamatan',
                'kabupaten' => 'Kabupaten',
                'provinsi' => 'Provinsi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
