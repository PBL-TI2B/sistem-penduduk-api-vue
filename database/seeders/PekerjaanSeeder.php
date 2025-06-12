<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pekerjaan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'PNS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Petani',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Pedagang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Wiraswasta',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Buruh',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'TNI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Polri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Guru',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Dokter',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'uuid' => Str::uuid(),
                'nama_pekerjaan' => 'Pengacara',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
