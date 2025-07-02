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
                'id' => 1, // Untuk user rt001
                'uuid' => Str::uuid(),
                'penduduk_id' => 1, // John Doe dari PendudukSeeder
                'jabatan_id' => 1, // Ketua RT dari JabatanSeeder
                'periode_jabatan_id' => 1,
                'status_keaktifan' => 'aktif',
                'desa_id' => null,
                'dusun_id' => null,
                'rt_id' => 1, // Mengurus RT 001
                'rw_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2, // Untuk user rt002
                'uuid' => Str::uuid(),
                'penduduk_id' => 2, // Jane Doe dari PendudukSeeder
                'jabatan_id' => 1, // Ketua RT dari JabatanSeeder
                'periode_jabatan_id' => 1,
                'status_keaktifan' => 'aktif',
                'desa_id' => 1,
                'dusun_id' => null,
                'rt_id' => null,
                'rw_id' => 1, // Di bawah RW 001
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3, // Untuk user rw001
                'uuid' => Str::uuid(),
                'penduduk_id' => 3, // Michael Smith dari PendudukSeeder
                'jabatan_id' => 2, // Ketua RW dari JabatanSeeder
                'periode_jabatan_id' => 1,
                'status_keaktifan' => 'aktif',
                'desa_id' => 1,
                'dusun_id' => null,
                'rt_id' => null,
                'rw_id' => 2, // Mengurus RW 002
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4, // Untuk user rw002
                'uuid' => Str::uuid(),
                'penduduk_id' => 4, // Jane Doe dari PendudukSeeder
                'jabatan_id' => 2, // Ketua RW dari JabatanSeeder
                'periode_jabatan_id' => 1,
                'status_keaktifan' => 'aktif',
                'desa_id' => 1,
                'dusun_id' => null,
                'rt_id' => null, // Tidak spesifik mengurus RT
                'rw_id' => 1, // Mengurus RW 001
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}