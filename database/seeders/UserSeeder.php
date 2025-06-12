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
            'password' => Hash::make('password'),
            'status' => 'AKTIF',
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
            'password' => Hash::make('password'),
            'status' => 'AKTIF',
            'perangkat_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('admin');
    }

    private function createUserRt()
    {
        $user = User::create([
            'id' => 3,
            'uuid' => (string) Str::uuid(),
            'username' => 'rt001',
            'password' => Hash::make('password'),
            'status' => 'AKTIF',
            'perangkat_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('rt');
    }

    private function createUserRw()
    {
        $user = User::create([
            'id' => 4,
            'uuid' => (string) Str::uuid(),
            'username' => 'rw001',
            'password' => Hash::make('password'),
            'status' => 'AKTIF',
            'perangkat_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('rw');
    }
}
