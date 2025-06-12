<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RiwayatBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('riwayat_bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penerima_bantuan_id' => 1,
                'status' => 'diterima',
                'tanggal_penerimaan'=>'2021-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
