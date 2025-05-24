<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $rt = Role::firstOrCreate(['name' => 'rt']);
        $rw = Role::firstOrCreate(['name' => 'rw']);

        $resources = [
            'rt', 'rw', 'desa', 'user', 'dusun', 'berita', 'galeri', 'jabatan',
            'bantuan', 'kematian', 'penduduk', 'domisili', 'pindahan', 'pekerjaan',
            'kelahiran', 'pendidikan', 'notifikasi', 'kurang-mampu', 'kartu-keluarga',
            'perangkat-desa', 'status-keluarga', 'riwayat-bantuan', 'periode-jabatan',
            'penerima-bantuan', 'anggota-keluarga', 'kategori-bantuan', 'notifikasi-penerima'
        ];

        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$resource}.{$action}"]);
            }
        }

        $superAdmin = Role::findByName('superadmin');
        $admin = Role::findByName('admin');
        $rt = Role::findByName('rt');
        $rw = Role::findByName('rw');

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo([
            'penerima-bantuan.read',
            'penerima-bantuan.create',
            'penerima-bantuan.update',
            'anggota-keluarga.read',
            'anggota-keluarga.create',
            'anggota-keluarga.update',
            'domisili.read',
            'domisili.create',
            'domisili.update',
            'domisili.delete',
            'pindahan.read',
            'pindahan.create',
            'pindahan.update',
            'pindahan.delete',
            'kartu-keluarga.read',
            'kartu-keluarga.create',
            'kartu-keluarga.update',
            'kurang-mampu.read',
            'kurang-mampu.create',
            'kurang-mampu.update',
            'notifikasi-penerima.read',
            'notifikasi-penerima.create',
            'kelahiran.read',
            'kelahiran.create',
            'kelahiran.update',
            'penduduk.read',
            'penduduk.create',
            'penduduk.update',
            'kematian.read',
            'kematian.create',
            'kematian.update',
            'riwayat-bantuan.read',
            'riwayat-bantuan.create',
            'notifikasi.read',
            'notifikasi.create',
            'pekerjaan.read',
            'pendidikan.read',
            'bantuan.read',
        ]);

        $rw->givePermissionTo([
            'penduduk.read',
            'domisili.read',
            'domisili.create',
            'domisili.update',
            'kematian.read',
            'kematian.create',
            'kelahiran.read',
            'kelahiran.create',
            'pindahan.read',
            'pindahan.create',
            'pindahan.update',

            'kurang-mampu.read',
            'kurang-mampu.create',
            'kurang-mampu.update',
            'notifikasi.read',
            'notifikasi.create',

            'penerima-bantuan.read',
            'penerima-bantuan.create',
            'penerima-bantuan.update',
            'riwayat-bantuan.read',
            'riwayat-bantuan.create',
        ]);

        $rt->syncPermissions([
            'penduduk.read',
            'domisili.read',
            'domisili.create',
            'kematian.read',
            'kematian.create',
            'kelahiran.read',
            'kelahiran.create',
            'pindahan.read',
            'pindahan.create',
            'kurang-mampu.read',
            'kurang-mampu.create',

            'notifikasi.read',
            'notifikasi.create',

            'penerima-bantuan.read',
            'penerima-bantuan.create',
            'riwayat-bantuan.read',
            'riwayat-bantuan.create',
        ]);
    }
}
