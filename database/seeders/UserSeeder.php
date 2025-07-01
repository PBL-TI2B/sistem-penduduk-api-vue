<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperadmin();
        $this->createAdmin();
        $this->createUserRt();
        $this->createUserRw();
    }

    private function createSuperadmin()
    {
        $user = User::create([
            'id' => 1,
            'uuid' => (string) Str::uuid(),
            'username' => 'superadmin',
            'password' => Hash::make('password'), // Ganti di production
            'status' => 'aktif',
            'perangkat_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('superadmin');
    }

    private function createAdmin()
    {
        $user = User::create([
            'id' => 2,
            'uuid' => (string) Str::uuid(),
            'username' => 'admin',
            'password' => Hash::make('password'), // Ganti di production
            'status' => 'aktif',
            'perangkat_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('admin');
    }

    private function createUserRt()
    {
        // User untuk Ketua RT 001
        $userRt1 = User::create([
            'id' => 3,
            'uuid' => (string) Str::uuid(),
            'username' => 'rt001',
            'password' => Hash::make('password'), // Ganti di production
            'status' => 'aktif',
            'perangkat_id' => 1, // Terhubung ke perangkat_desa.id = 1
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $userRt1->assignRole('rt');

        // User untuk Ketua RT 002
        $userRt2 = User::create([
            'id' => 4,
            'uuid' => (string) Str::uuid(),
            'username' => 'rt002',
            'password' => Hash::make('password'), // Ganti di production
            'status' => 'aktif',
            'perangkat_id' => 2, // Terhubung ke perangkat_desa.id = 2
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $userRt2->assignRole('rt');
    }

    private function createUserRw()
    {
        $userRw1 = User::create([
            'id' => 5,
            'uuid' => (string) Str::uuid(),
            'username' => 'rw001',
            'password' => Hash::make('password'), // Ganti di production
            'status' => 'aktif',
            'perangkat_id' => 3, // Terhubung ke perangkat_desa.id = 3
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $userRw1->assignRole('rw');

        $userRw2 = User::create([
            'id' => 6,
            'uuid' => (string) Str::uuid(),
            'username' => 'rw002',
            'password' => Hash::make('password'), // Ganti di production
            'status' => 'aktif',
            'perangkat_id' => 4, // Terhubung ke perangkat_desa.id = 4
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $userRw2->assignRole('rw');
    }
}