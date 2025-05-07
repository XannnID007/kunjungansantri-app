<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\WaliSantriController;
use App\Http\Controllers\Admin\JadwalOperasionalController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;

// Petugas Controllers
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\KunjunganController as PetugasKunjunganController;
use App\Http\Controllers\Petugas\BarangController;
use App\Http\Controllers\Petugas\AntrianController;

// Wali Santri Controllers
use App\Http\Controllers\WaliSantri\DashboardController as WaliDashboardController;
use App\Http\Controllers\WaliSantri\KunjunganController as WaliKunjunganController;

// Public Controllers
use App\Http\Controllers\PublicController;

// Default Laravel Controller
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route redirect setelah login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('santri', SantriController::class);
    Route::resource('wali-santri', WaliSantriController::class);
    Route::resource('jadwal', JadwalOperasionalController::class);
    Route::patch('/jadwal/{jadwal}/toggle-status', [JadwalOperasionalController::class, 'toggleStatus'])->name('jadwal.toggleStatus');
    Route::resource('kunjungan', AdminKunjunganController::class);
    Route::resource('users', UserController::class);
    Route::patch('/users/{active}/toggle-active', [UserController::class, 'toggleActive'])->name('jadwal.toggleActive');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/kunjungan', [LaporanController::class, 'kunjungan'])->name('laporan.kunjungan');
    Route::get('/laporan/barang', [LaporanController::class, 'barang'])->name('laporan.barang');
    Route::get('/laporan/pdf/{type}', [LaporanController::class, 'generatePdf'])->name('laporan.pdf');
    Route::get('/laporan/excel/{type}', [LaporanController::class, 'generateExcel'])->name('laporan.excel');
});

// Petugas Routes
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kunjungan', PetugasKunjunganController::class);
    Route::resource('barang', BarangController::class);

    // Antrian
    Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');
    Route::post('/antrian/next', [AntrianController::class, 'nextQueue'])->name('antrian.next');
    Route::post('/antrian/check-in', [AntrianController::class, 'checkIn'])->name('antrian.check-in');
    Route::post('/antrian/complete/{id}', [AntrianController::class, 'complete'])->name('antrian.complete');
    Route::post('/antrian/cancel/{id}', [AntrianController::class, 'cancel'])->name('antrian.cancel');
    Route::post('/antrian/register-walk', [AntrianController::class, 'registerWalk'])->name('antrian.register-walk');

    // Barang
    Route::post('/scan-barang', [BarangController::class, 'scanBarang'])->name('barang.scan');
    Route::post('/update-status-barang/{id}', [BarangController::class, 'updateStatus'])->name('barang.update-status');
});

// Wali Santri Routes
Route::middleware(['auth', 'role:wali_santri'])->prefix('wali')->name('wali.')->group(function () {
    Route::get('/dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kunjungan', WaliKunjunganController::class);
    Route::get('/jadwal-tersedia', [WaliKunjunganController::class, 'jadwalTersedia'])->name('jadwal-tersedia');
});

// Public Routes
Route::get('/check-antrian/{kode}', [PublicController::class, 'checkAntrian'])->name('check-antrian');
Route::get('/display-antrian', [PublicController::class, 'displayAntrian'])->name('display-antrian');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
