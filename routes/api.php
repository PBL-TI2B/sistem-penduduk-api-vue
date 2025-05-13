<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\V1\KematianController;
// use App\Http\Controllers\Api\V1\AuthController;
// use App\Http\Controllers\Api\V1\PendudukController;
// use App\Http\Controllers\Api\V1\PerangkatDesaController;
// use App\Http\Controllers\Api\V1\RwController;
// use App\Http\Controllers\Api\V1\RtController;
// use App\Http\Controllers\Api\V1\DusunController;
// use App\Http\Controllers\Api\V1\DesaController;
// use App\Http\Controllers\Api\V1\PekerjaanController;
// use App\Http\Controllers\Api\V1\KelahiranController;
// use App\Http\Controllers\Api\V1\JabatanController;
// use App\Http\Controllers\Api\V1\PeriodeJabatanController;
// use App\Http\Controllers\Api\V1\BeritaController;
// use App\Http\Controllers\Api\V1\AnggotaKeluargaController;
// use App\Http\Controllers\Api\V1\StatusKeluargaController;
// use App\Http\Controllers\Api\V1\NotifikasiController;
// use App\Http\Controllers\Api\V1\NotifikasiPenerimaController;
// use App\Http\Controllers\Api\V1\PindahanController;
// use App\Http\Controllers\Api\V1\PendidikanController;
// use App\Http\Controllers\Api\V1\DomisiliController;
// use App\Http\Controllers\Api\V1\GaleriController;
// use App\Http\Controllers\Api\V1\KartuKeluargaController;
// use App\Http\Controllers\Api\V1\KurangMampuController;
// use App\Http\Controllers\Api\V1\KategoriBantuanController;
// use App\Http\Controllers\Api\V1\BantuanController;
// use App\Http\Controllers\Api\V1\PenerimaBantuanController;
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
    NotifikasiPenerimaController,
    AnggotaKeluargaController,
    StatusKeluargaController,
    KategoriBantuanController,
    BantuanController,
    DomisiliController,
    KelahiranController,
    NotifikasiController,
    PekerjaanController,
    InfografisController,
    PenerimaBantuanController,
    PendidikanController,
    RtController,
    RwController
};

Route::prefix('v1')->group(function () {
    // PUBLIC ROUTES
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {

        RoutePermission('galeri', GaleriController::class, 'galeri', true);
        RoutePermission('berita', BeritaController::class, 'berita', true);
        RoutePermission('penduduk', PendudukController::class, 'penduduk', true);
        RoutePermission('perangkat-desa', PerangkatDesaController::class, 'perangkatDesa', true);
        RoutePermission('dusun', DusunController::class, 'dusun', true);
        RoutePermission('desa', DesaController::class, 'desa', true);
        RoutePermission('bantuan', BantuanController::class, 'bantuan', true);
        RoutePermission('pekerjaan', PekerjaanController::class, 'pekerjaan', true);
        RoutePermission('pendidikan', PendidikanController::class, 'pendidikan', true);

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


            Route::get('/auth/me', [AuthController::class, 'me']);
            Route::post('/auth/logout', [AuthController::class, 'logout']);
            Route::get('/penduduk/foto/{filename}', [PendudukController::class, 'getFoto']);

            Route::apiResource('/anggota-keluarga', AnggotaKeluargaController::class);
            Route::apiResource('/status-keluarga', StatusKeluargaController::class);
            Route::apiResource('/kartu-keluarga', KartuKeluargaController::class);
            Route::apiResource('/kurang-mampu', KurangMampuController::class);
            Route::apiResource('/kategori-bantuan', KategoriBantuanController::class);
            Route::apiResource('/bantuan', BantuanController::class);
            Route::apiResource('/penerima-bantuan', PenerimaBantuanController::class);

            RoutePermission('rt', RtController::class, 'rt');
            RoutePermission('rw', RwController::class, 'rw');
            RoutePermission('jabatan', JabatanController::class, 'jabatan');
            RoutePermission('periode-jabatan', PeriodeJabatanController::class, 'periodeJabatan');
            RoutePermission('user', UserController::class, 'user');
            RoutePermission('kematian', KematianController::class, 'kematian');
            RoutePermission('pindahan', PindahanController::class, 'pindahan');
            RoutePermission('kartu-keluarga', KartuKeluargaController::class, 'kartuKeluarga');
            RoutePermission('kurang-mampu', KurangMampuController::class, 'kurangMampu');
            RoutePermission('notifikasi-penerima', NotifikasiPenerimaController::class, 'notifikasiPenerima');
            RoutePermission('anggota-keluarga', AnggotaKeluargaController::class, 'anggotaKeluarga');
            RoutePermission('status-keluarga', StatusKeluargaController::class, 'statusKeluarga');
            RoutePermission('kategori-bantuan', KategoriBantuanController::class, 'kategoriBantuan');
            RoutePermission('domisili', DomisiliController::class, 'domisili');
            RoutePermission('kelahiran', KelahiranController::class, 'kelahiran');
            RoutePermission('notifikasi', NotifikasiController::class, 'notifikasi');
            // RoutePermission('penerima-bantuan', PenerimaBantuanController::class, 'penerimaBantuan');
        });
    });
});
