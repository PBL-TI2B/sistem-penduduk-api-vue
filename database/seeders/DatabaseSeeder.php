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
        DB::table('desa')->insert([
            [
                'id'=>1,
                'uuid'=>Str::uuid(),
                'nama'=>'Desa Jabung',
                'deskripsi'=> 'Desa Jabung adalah desa yang terletak di Kabupaten Klaten',
                'lokasi'=>'Kabupaten Klaten, Provinsi Jawa Tengah',
            ]
        ]);

        DB::table('dusun')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nama' => 'Dusun Jabung',
                'deskripsi' => 'Dusun Jabung adalah dusun yang terletak di Desa Jabung',
                'lokasi' => 'Desa Jabung, Kabupaten Klaten',
                'desa_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('pendidikan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'jenjang' => 'Tidak Sekolah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'jenjang' => 'SD',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid(),
                'jenjang' => 'SMP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid(),
                'jenjang' => 'SMA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'uuid' => Str::uuid(),
                'jenjang' => 'SMK',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'uuid' => Str::uuid(),
                'jenjang' => 'D3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'uuid' => Str::uuid(),
                'jenjang' => 'D4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'uuid' => Str::uuid(),
                'jenjang' => 'S1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'uuid' => Str::uuid(),
                'jenjang' => 'S2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'uuid' => Str::uuid(),
                'jenjang' => 'S3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

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

        DB::table('penduduk')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123456',
                'nama_lengkap' => 'John Doe',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1990-01-01',
                'tempat_lahir' => 'Jakarta',
                'gol_darah' => 'A',
                'status_perkawinan' => 'kawin',
                'pekerjaan_id' => 2,
                'pendidikan_id' => 1,
                'foto' => 'default.jpg',
                'tinggi_badan' => 170,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123457',
                'nama_lengkap' => 'Jane Doe',
                'agama' => 'Islam',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1992-02-02',
                'tempat_lahir' => 'Bandung',
                'gol_darah' => 'B',
                'status_perkawinan' => 'belum kawin',
                'pekerjaan_id' => 3,
                'pendidikan_id' => 2,
                'foto' => 'default.jpg',
                'tinggi_badan' => 160,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123458',
                'nama_lengkap' => 'Michael Smith',
                'agama' => 'Kristen',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1988-03-03',
                'tempat_lahir' => 'Surabaya',
                'gol_darah' => 'O',
                'status_perkawinan' => 'kawin',
                'pekerjaan_id' => 1,
                'pendidikan_id' => 3,
                'foto' => 'default.jpg',
                'tinggi_badan' => 175,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123459',
                'nama_lengkap' => 'Sarah Connor',
                'agama' => 'Katolik',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1995-04-04',
                'tempat_lahir' => 'Yogyakarta',
                'gol_darah' => 'AB',
                'status_perkawinan' => 'kawin',
                'pekerjaan_id' => 4,
                'pendidikan_id' => 4,
                'foto' => 'default.jpg',
                'tinggi_badan' => 165,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123460',
                'nama_lengkap' => 'David Brown',
                'agama' => 'Hindu',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1993-05-05',
                'tempat_lahir' => 'Denpasar',
                'gol_darah' => 'A',
                'status_perkawinan' => 'belum kawin',
                'pekerjaan_id' => 5,
                'pendidikan_id' => 5,
                'foto' => 'default.jpg',
                'tinggi_badan' => 180,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123461',
                'nama_lengkap' => 'Emily White',
                'agama' => 'Buddha',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1991-06-06',
                'tempat_lahir' => 'Medan',
                'gol_darah' => 'B',
                'status_perkawinan' => 'kawin',
                'pekerjaan_id' => 6,
                'pendidikan_id' => 6,
                'foto' => 'default.jpg',
                'tinggi_badan' => 158,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'uuid' => Str::uuid(),
                'nik' => '1234567890123462',
                'nama_lengkap' => 'Liam Anderson',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1994-07-07',
                'tempat_lahir' => 'Makassar',
                'gol_darah' => 'O',
                'status_perkawinan' => 'kawin',
                'pekerjaan_id' => 7,
                'pendidikan_id' => 7,
                'foto' => 'default.jpg',
                'tinggi_badan' => 172,
                'status' => 'hidup',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('jabatan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'jabatan' => 'Ketua RT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(),
                'jabatan' => 'Ketua RW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('periode_jabatan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'awal_menjabat' => '2021-01-01',
                'akhir_menjabat' => '2023-01-01',
                'keterangan' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        $rwUuid = Str::uuid();
        DB::table('rw')->insert([
            [
                'id' => 1,
                'uuid' => $rwUuid,
                'nomor_rw' => '001',
                'dusun_id'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('rt')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nomor_rt' => '001',
                'rw_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('perangkat_desa')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penduduk_id' => 1,
                'jabatan_id' => 1,
                'periode_jabatan_id' => 1,
                'status_keaktifan' => 'AKTIF',
                'desa_id'=> 1,
                'dusun_id' => 1,
                'rt_id' => 1,
                'rw_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('users')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'status' => 'AKTIF',
                'perangkat_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('domisili')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'rt_id' => 1,
                'penduduk_id' => 1,
                'status_tempat_tinggal' => 'tetap',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('kartu_keluarga')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nomor_kk' => '1234567890123456',
                'rt_id' => 1,
                'kode_pos' => '12345',
                'kelurahan' => 'Kelurahan',
                'kecamatan' => 'Kecamatan',
                'kabupaten' => 'Kabupaten',
                'provinsi' => 'Provinsi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('status_keluarga')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'status_keluarga' => 'Kepala Keluarga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('anggota_keluarga')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'kk_id' => 1,
                'penduduk_id' => 1,
                'status_keluarga_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('kurang_mampu')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'anggota_keluarga_id' => 1,
                'pendapatan_per_hari' => 100000,
                'pendapatan_per_bulan' => 3000000,
                'jumlah_tanggungan' => 3,
                'status_validasi' => 'terverifikasi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('kategori_bantuan')->insert([
            'id'=>1,
            'uuid'=>Str::uuid(),
            'kategori'=>'tunai',
            'keterangan'=>''
        ]);

        DB::table('bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'nama_bantuan' => 'Bantuan Sosial Tunai',
                // 'kategori_bantuan' => 'tunai',
                'kategori_bantuan_id'=>1,
                'periode' => '2021',
                'lama_periode' => 3,
                'instansi' => 'Pemerintah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('penerima_bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'kurang_mampu_id' => 1,
                'bantuan_id' => 1,
                'status'=>'selesai',
                'tanggal_penerimaan'=>'2021-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('riwayat_bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penerima_bantuan_id' => 1,
                'status' => 'diterima',
                'tanggal_penerimaan'=>'2021-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('kelahiran')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penduduk_id' => 1,
                'anak_ke' => 1,
                'berat' => 3.5,
                'panjang'=> 50,
                'waktu_kelahiran' => '2021-01-01 08:00:00',
                'lokasi'=>'Rumah Sakit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('pindahan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penduduk_id' => 1,
                'status_pindahan' => 'masuk',
                'tanggal_pindahan' => '2021-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('kematian')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(),
                'penduduk_id' => 1,
                'tanggal_kematian' => '2021-01-01',
                'sebab_kematian' => 'Sakit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
