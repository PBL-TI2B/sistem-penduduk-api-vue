<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DusunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dusun')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nama' => 'Dusun Jabung',
                'deskripsi' => 'Dusun Jabung adalah dusun yang terletak di Desa Jabung',
                'lokasi' => 'Desa Jabung, Kabupaten Klaten',
                'desa_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
