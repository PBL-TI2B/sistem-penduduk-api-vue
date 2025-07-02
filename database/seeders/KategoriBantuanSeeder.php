<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KategoriBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'kategori' => 'tunai',
                'keterangan' => 'Bantuan dalam bentuk uang tunai.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'kategori' => 'pangan',
                'keterangan' => 'Bantuan dalam bentuk bahan makanan pokok atau sembako.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid(),
                'kategori' => 'pendidikan',
                'keterangan' => 'Bantuan untuk mendukung biaya pendidikan, seperti beasiswa atau perlengkapan sekolah.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid(),
                'kategori' => 'kesehatan',
                'keterangan' => 'Bantuan terkait layanan kesehatan, obat-obatan, atau alat bantu medis.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'uuid' => Str::uuid(),
                'kategori' => 'perumahan',
                'keterangan' => 'Bantuan untuk perbaikan atau pembangunan rumah layak huni.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'uuid' => Str::uuid(),
                'kategori' => 'modal usaha',
                'keterangan' => 'Bantuan berupa modal untuk memulai atau mengembangkan usaha kecil.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'uuid' => Str::uuid(),
                'kategori' => 'disabilitas',
                'keterangan' => 'Bantuan khusus untuk penyandang disabilitas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'uuid' => Str::uuid(),
                'kategori' => 'bencana alam',
                'keterangan' => 'Bantuan darurat untuk korban bencana alam.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}