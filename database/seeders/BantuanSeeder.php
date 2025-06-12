<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nama_bantuan' => 'Bantuan Sosial Tunai',
                // 'kategori_bantuan' => 'tunai',
                'kategori_bantuan_id'=>1,
                'periode' => '2021',
                'lama_periode' => 3,
                'instansi' => 'Pemerintah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
