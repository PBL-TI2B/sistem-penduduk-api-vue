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
        Route::get('/penduduk/export/excel', [PendudukController::class, 'exportExcel']);
        Route::get('/dusun/export/pdf', [DusunController::class, 'exportPdf']);
        Route::get('/kurang-mampu/export/pdf', [KurangMampuController::class, 'exportPdf']);
        Route::get('/pekerjaan/export/pdf', [PekerjaanController::class, 'exportPdf']);
        Route::get('/pendidikan/export/pdf', [PendidikanController::class, 'exportPdf']);
        Route::get('/perangkat-desa/export/pdf', [PerangkatDesaController::class, 'exportPdf']);
        Route::get('/pindahan/export/pdf', [PindahanController::class, 'exportPdf']);
        Route::get('/bantuan/export/pdf', [BantuanController::class, 'exportPdf']);
        Route::get('/bantuan/export/excel', [BantuanController::class, 'exportExcel']);


        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/penduduk/foto/{filename}', [PendudukController::class, 'getFoto']);
        Route::get('/galeri/image/{filename}', [GaleriController::class, 'getGaleri']);
        

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
        RoutePermission('penerima-bantuan', PenerimaBantuanController::class, 'penerimaBantuan');
    });
});
