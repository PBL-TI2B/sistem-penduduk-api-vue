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
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name'=>'sanctum']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name'=>'sanctum']);
        $rt = Role::firstOrCreate(['name' => 'rt', 'guard_name'=>'sanctum']);
        $rw = Role::firstOrCreate(['name' => 'rw', 'guard_name'=>'sanctum']);

        $resources = [
            'rt',
            'rw',
            'desa',
            'user',
            'dusun',
            'berita',
            'galeri',
            'jabatan',
            'bantuan',
            'kematian',
            'penduduk',
            'domisili',
            'pindahan',
            'pekerjaan',
            'kelahiran',
            'pendidikan',
            'notifikasi',
            'kurang-mampu',
            'kartu-keluarga',
            'perangkat-desa',
            'status-keluarga',
            'riwayat-bantuan',
            'periode-jabatan',
            'penerima-bantuan',
            'anggota-keluarga',
            'kategori-bantuan',
            'notifikasi-penerima'
        ];

        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$resource}.{$action}", 'guard_name' => 'sanctum']);
            }
        }

        $superAdmin = Role::findByName('superadmin', 'sanctum');
        $admin = Role::findByName('admin', 'sanctum');
        $rt = Role::findByName('rt', 'sanctum');
        $rw = Role::findByName('rw', 'sanctum');

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo([
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
            'notifikasi.read',
            'notifikasi.create',
            'pekerjaan.read',
            'pendidikan.read',
            'berita.read',
            'berita.create',
            'berita.update',
            'berita.delete',
            'galeri.read',
            'galeri.create',
            'galeri.update',
            'galeri.delete',
            'kategori-bantuan.read',
            'bantuan.read',
            'bantuan.create',
            'bantuan.update',
            'bantuan.delete',
            'kurang-mampu.read',
            'kurang-mampu.create',
            'kurang-mampu.update',
            'kurang-mampu.delete',
            'penerima-bantuan.read',
            'penerima-bantuan.create',
            'penerima-bantuan.update',
            'penerima-bantuan.delete',
            'riwayat-bantuan.read',
            'riwayat-bantuan.create',
            'riwayat-bantuan.update',
            'riwayat-bantuan.delete',
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

            'kategori-bantuan.read',

            'bantuan.read',

            'kurang-mampu.read',
            'kurang-mampu.create',
            'kurang-mampu.update',
            'kurang-mampu.delete',

            'penerima-bantuan.read',
            'penerima-bantuan.create',
            'penerima-bantuan.update',
            'penerima-bantuan.delete',

            'riwayat-bantuan.read',
            'riwayat-bantuan.update',

            // 'notifikasi.read',
            // 'notifikasi.create',
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

            'kategori-bantuan.read',

            'bantuan.read',

            'kurang-mampu.read',
            'kurang-mampu.create',
            'kurang-mampu.update',
            'kurang-mampu.delete',

            'penerima-bantuan.read',
            'penerima-bantuan.create',
            'penerima-bantuan.update',
            'penerima-bantuan.delete',

            'riwayat-bantuan.read',
            'riwayat-bantuan.update',
        ]);
    }
}