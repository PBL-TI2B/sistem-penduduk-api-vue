<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StatusKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusKeluarga = [
            'Kepala Keluarga',
            'Istri',
            'Anak',
            'Orang Tua',
            'Menantu',
            'Cucu',
            'Famili Lain',
            'Pembantu',
        ];

        foreach ($statusKeluarga as $index => $status) {
            DB::table('status_keluarga')->insert([
                'id' => $index + 1,
                'uuid' => Str::uuid(),
                'status_keluarga' => $status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
