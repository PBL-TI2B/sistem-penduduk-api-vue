<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bantuan')->insert([
            [
                'id' => 1,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Sosial Tunai (BST)',
                // 'kategori_bantuan' => 'tunai',
                'kategori_bantuan_id' => 1, // Tunai
                'status' => 'aktif',
                'nominal' => '300000',
                'periode' => '2021',
                'lama_periode' => '3 Bulan',
                'instansi' => 'Pemerintah Pusat',
                'keterangan' => 'Bantuan sosial tunai yang diberikan selama pandemi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Program Keluarga Harapan (PKH)',
                'kategori_bantuan_id' => 1, // Tunai
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Tahunan',
                'lama_periode' => 'Berkelanjutan',
                'instansi' => 'Kementerian Sosial',
                'keterangan' => 'Nominal bervariasi tergantung komponen dalam keluarga (Ibu Hamil, Anak Sekolah, Lansia, Disabilitas). Diberikan per tahap dalam setahun.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Langsung Tunai (BLT) Dana Desa',
                'kategori_bantuan_id' => 1, // Tunai
                'status' => 'aktif',
                'nominal' => '300000',
                'periode' => 'Bulanan',
                'lama_periode' => '12 Bulan',
                'instansi' => 'Pemerintah Desa',
                'keterangan' => 'Bantuan tunai yang bersumber dari Dana Desa untuk warga miskin di desa.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Pangan Non Tunai (BPNT) / Kartu Sembako',
                'kategori_bantuan_id' => 2, // Pangan
                'status' => 'aktif',
                'nominal' => '200000',
                'periode' => 'Bulanan',
                'lama_periode' => '12 Bulan',
                'instansi' => 'Kementerian Sosial',
                'keterangan' => 'Bantuan pangan yang disalurkan secara non-tunai setiap bulan untuk dibelanjakan bahan pokok di e-warong.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Distribusi Beras Cadangan Pangan Pemerintah (CPP)',
                'kategori_bantuan_id' => 2, // Pangan
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Insidental',
                'lama_periode' => '1 Kali',
                'instansi' => 'Badan Pangan Nasional',
                'keterangan' => 'Bantuan berupa 10 kg beras per keluarga penerima manfaat.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Kartu Indonesia Pintar (KIP)',
                'kategori_bantuan_id' => 3, // Pendidikan
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Tahunan',
                'lama_periode' => 'Sesuai Jenjang',
                'instansi' => 'Kementerian Pendidikan dan Kebudayaan',
                'keterangan' => 'Bantuan pendidikan untuk siswa dari keluarga miskin/rentan miskin. Nominal bervariasi per jenjang (SD, SMP, SMA/SMK).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Beasiswa KIP Kuliah',
                'kategori_bantuan_id' => 3, // Pendidikan
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Semester',
                'lama_periode' => 'Sesuai Masa Studi',
                'instansi' => 'Kementerian Pendidikan dan Kebudayaan',
                'keterangan' => 'Bantuan biaya pendidikan dan biaya hidup untuk mahasiswa dari keluarga tidak mampu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'BPJS Kesehatan PBI (Penerima Bantuan Iuran)',
                'kategori_bantuan_id' => 4, // Kesehatan
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Bulanan',
                'lama_periode' => 'Berkelanjutan',
                'instansi' => 'Kementerian Kesehatan',
                'keterangan' => 'Bantuan iuran jaminan kesehatan bagi fakir miskin dan orang tidak mampu yang iurannya dibayar oleh Pemerintah.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Stimulan Perumahan Swadaya (BSPS) / Bedah Rumah',
                'kategori_bantuan_id' => 5, // Perumahan
                'status' => 'aktif',
                'nominal' => '20000000',
                'periode' => 'Insidental',
                'lama_periode' => '1 Kali',
                'instansi' => 'Kementerian PUPR',
                'keterangan' => 'Bantuan pemerintah bagi masyarakat berpenghasilan rendah untuk mendorong dan meningkatkan keswadayaan dalam peningkatan kualitas rumah.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Kredit Usaha Rakyat (KUR)',
                'kategori_bantuan_id' => 6, // Modal Usaha
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Sesuai Tenor',
                'lama_periode' => 'Sesuai Tenor',
                'instansi' => 'Bank Himbara',
                'keterangan' => 'Kredit/pembiayaan modal kerja dan/atau investasi kepada debitur individu/perseorangan, badan usaha yang produktif dan layak namun belum memiliki agunan tambahan. Nominal bervariasi hingga Rp 500.000.000.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Produktif Usaha Mikro (BPUM)',
                'kategori_bantuan_id' => 6, // Modal Usaha
                'status' => 'nonaktif', // Contoh status nonaktif
                'nominal' => '1200000',
                'periode' => 'Insidental',
                'lama_periode' => '1 Kali',
                'instansi' => 'Kementerian Koperasi dan UKM',
                'keterangan' => 'Bantuan modal bagi pelaku usaha mikro yang terdampak pandemi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Asistensi Sosial Penyandang Disabilitas (ASPD)',
                'kategori_bantuan_id' => 7, // Disabilitas
                'status' => 'aktif',
                'nominal' => '300000',
                'periode' => 'Bulanan',
                'lama_periode' => '12 Bulan',
                'instansi' => 'Kementerian Sosial',
                'keterangan' => 'Bantuan yang diberikan kepada penyandang disabilitas dari keluarga tidak mampu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 13,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Logistik Korban Bencana',
                'kategori_bantuan_id' => 8, // Bencana Alam
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Darurat',
                'lama_periode' => 'Sesuai Kebutuhan',
                'instansi' => 'BNPB/BPBD',
                'keterangan' => 'Bantuan darurat berupa logistik seperti paket sembako, selimut, tenda, dll untuk korban bencana alam.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 14,
                'uuid' => Str::uuid(), // UUID unik
                'nama_bantuan' => 'Bantuan Pembangunan Kembali Rumah Rusak Akibat Bencana',
                'kategori_bantuan_id' => 8, // Bencana Alam
                'status' => 'aktif',
                'nominal' => null,
                'periode' => 'Insidental',
                'lama_periode' => '1 Kali',
                'instansi' => 'BNPB/Kementerian PUPR',
                'keterangan' => 'Bantuan dana untuk pembangunan kembali rumah yang rusak akibat bencana. Nominal bervariasi tergantung tingkat kerusakan (Ringan, Sedang, Berat).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}