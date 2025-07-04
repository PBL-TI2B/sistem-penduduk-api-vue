<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    AuthController,
    PendudukController,
    DesaController,
    DusunController,
    JabatanController,
    PeriodeJabatanController,
    GaleriController,
    BeritaController,
    UserController,
    PerangkatDesaController,
    KematianController,
    PindahanController,
    KartuKeluargaController,
    KurangMampuController,
    AnggotaKeluargaController,
    StatusKeluargaController,
    KategoriBantuanController,
    BantuanController,
    DomisiliController,
    KelahiranController,
    PekerjaanController,
    InfografisController,
    PenerimaBantuanController,
    RiwayatBantuanController,
    PendidikanController,
    RtController,
    RwController
};

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    // PUBLIC ROUTES
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    RoutePermission('galeri', GaleriController::class, 'galeri', true);
    RoutePermission('berita', BeritaController::class, 'berita', true);
    RoutePermission('dusun', DusunController::class, 'dusun', true);
    RoutePermission('desa', DesaController::class, 'desa', true);
    RoutePermission('bantuan', BantuanController::class, 'bantuan', true);
    RoutePermission('pekerjaan', PekerjaanController::class, 'pekerjaan');
    RoutePermission('penduduk', PendudukController::class, 'penduduk');
    RoutePermission('perangkat-desa', PerangkatDesaController::class, 'perangkatDesa', true);
    RoutePermission('pendidikan', PendidikanController::class, 'pendidikan');

    Route::prefix('statistik')->controller(InfografisController::class)->group(function () {
        Route::get('/pendidikan', 'statistikPendidikan');
        Route::get('/pekerjaan', 'statistikPekerjaan');
        Route::get('/kelahiran', 'statistikKelahiran');
        Route::get('/kematian', 'statistikKematian');
        Route::get('/agama', 'statistikAgama');
        Route::get('/umur', 'statistikUmur');
        Route::get('/demografi', 'statistikDemografi');
    });

    // AUTHENTICATED ROUTES
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/penduduk/export/pdf', [PendudukController::class, 'exportPdf']);
        Route::get('/penduduk/export/excel', [PendudukController::class, 'exportExcel']);
        Route::get('/dusun/export/pdf', [DusunController::class, 'exportPdf']);
        Route::get('/kurang-mampu/export/pdf', [KurangMampuController::class, 'exportPdf']);
        Route::get('/pekerjaan/export/pdf', [PekerjaanController::class, 'exportPdf']);
        Route::get('/pendidikan/export/pdf', [PendidikanController::class, 'exportPdf']);
        Route::get('/perangkat-desa/export/pdf', [PerangkatDesaController::class, 'exportPdf']);
        Route::get('/pindahan/export/pdf', [PindahanController::class, 'exportPdf']);

        Route::get('/bantuan/export/pdf', [BantuanController::class, 'exportPdf']);
        Route::get('/bantuan/export/excel', [BantuanController::class, 'exportExcel']);

        Route::get('/kurang-mampu/export/pdf', [KurangMampuController::class, 'exportPdf']);
        Route::get('/kurang-mampu/export/excel', [KurangMampuController::class, 'exportExcel']);

        Route::get('/penerima-bantuan/export/pdf', [PenerimaBantuanController::class, 'exportPdf']);
        Route::get('/penerima-bantuan/export/excel', [PenerimaBantuanController::class, 'exportExcel']);
        Route::get('/penerima-bantuan/{penerimaBantuan}/export/pdf', [PenerimaBantuanController::class, 'exportDetailPdf']);

        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/penduduk/foto/{filename}', [PendudukController::class, 'getFoto']);
        Route::get('/galeri/url_media/{filename}', [GaleriController::class, 'getGaleri']);
        Route::get('/berita/thumbnail/{filename}', [BeritaController::class, 'getBerita']);

        Route::get('/kartu-keluarga/check-kk', [KartuKeluargaController::class, 'checkNomorKK']);
        // ->middleware('permission:kartu-keluarga.create');
        Route::post('/anggota-keluarga/batch', [AnggotaKeluargaController::class, 'storeBatch']);
        // ->middleware('permission:anggota-keluarga.create');
    });

    RoutePermission('rt', RtController::class, 'rt');
    RoutePermission('rw', RwController::class, 'rw');
    RoutePermission('jabatan', JabatanController::class, 'jabatan');
    RoutePermission('periode-jabatan', PeriodeJabatanController::class, 'periodeJabatan');
    RoutePermission('user', UserController::class, 'user');
    RoutePermission('kematian', KematianController::class, 'kematian');
    RoutePermission('pindahan', PindahanController::class, 'pindahan');
    RoutePermission('kartu-keluarga', KartuKeluargaController::class, 'kartuKeluarga');
    RoutePermission('kurang-mampu', KurangMampuController::class, 'kurangMampu');
    RoutePermission('anggota-keluarga', AnggotaKeluargaController::class, 'anggotaKeluarga');
    RoutePermission('status-keluarga', StatusKeluargaController::class, 'statusKeluarga');
    RoutePermission('kategori-bantuan', KategoriBantuanController::class, 'kategoriBantuan');
    RoutePermission('domisili', DomisiliController::class, 'domisili');
    RoutePermission('kelahiran', KelahiranController::class, 'kelahiran');
    RoutePermission('penerima-bantuan', PenerimaBantuanController::class, 'penerimaBantuan');
    RoutePermission('riwayat-bantuan', RiwayatBantuanController::class, 'riwayatBantuan');
});