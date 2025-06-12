<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KelahiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelahiran')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penduduk_id' => 1,
                'anak_ke' => 1,
                'berat' => 3.5,
                'panjang'=> 50,
                'waktu_kelahiran' => '2021-01-01 08:00:00',
                'lokasi'=>'Rumah Sakit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
