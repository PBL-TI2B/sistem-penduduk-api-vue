<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('desa')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nama' => 'Desa Jabung',
                'deskripsi' => 'Desa Jabung adalah desa yang terletak di Kabupaten Klaten',
                'lokasi' => 'Kabupaten Klaten, Provinsi Jawa Tengah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
