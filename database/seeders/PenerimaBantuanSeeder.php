<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenerimaBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penerima_bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'kurang_mampu_id' => 1,
                'bantuan_id' => 1,
                'status'=>'selesai',
                'tanggal_penerimaan'=>'2021-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
