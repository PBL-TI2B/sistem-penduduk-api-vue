<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            DesaSeeder::class,
            DusunSeeder::class,
            PendidikanSeeder::class,
            PekerjaanSeeder::class,
            RwSeeder::class,
            RtSeeder::class,
            PendudukSeeder::class,
            JabatanSeeder::class,
            PeriodeJabatanSeeder::class,
            PerangkatDesaSeeder::class,
            UserSeeder::class,
            DomisiliSeeder::class,
            KartuKeluargaSeeder::class,
            StatusKeluargaSeeder::class,
            AnggotaKeluargaSeeder::class,
            KurangMampuSeeder::class,
            KategoriBantuanSeeder::class,
            BantuanSeeder::class,
            PenerimaBantuanSeeder::class,
            RiwayatBantuanSeeder::class,
            KelahiranSeeder::class,
            PindahanSeeder::class,
            KematianSeeder::class,
        ]);
    }
}
