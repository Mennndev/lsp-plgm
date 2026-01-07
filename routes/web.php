<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Homecontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TentangKamicontroller;
use App\Http\Controllers\VisiMisicontroller;
use App\Http\Controllers\KebijakanMutucontroller;
use App\Http\Controllers\StrukturOrganisasicontroller;
use App\Http\Controllers\Skemacontroller;
use App\Http\Controllers\admin\ProgramPelatihanController;
use App\Http\Controllers\admin\AdminBeritaController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\PengajuanSkemaController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


// Pendaftaran Routes
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tentang Kami Route
Route::get('/tentang-kami', [TentangKamicontroller::class, 'index'])->name('tentang-kami');

// Visi Misi Route
Route::get('/visi-misi', [VisiMisicontroller::class, 'index'])->name('visi-misi');

// Kebijakan Mutu Route
Route::get('/kebijakan-mutu', [KebijakanMutucontroller::class, 'index'])->name('kebijakan-mutu');

// Struktur Organisasi Route
Route::get('/struktur-organisasi', [StrukturOrganisasicontroller::class, 'index'])->name('struktur-organisasi');

//skema sertifikasi routes
Route::get('/skema-sertifikasi', [Skemacontroller::class, 'index'])->name('Skema.index');
Route::get('/skema/{program:slug}', [SkemaController::class, 'show'])
    ->name('Skema.show');

Route::get('/tempat-sertifikasi', function () {
    return view('tempat-sertifikasi');
});

// password reset routes
Route::get('/password/forgot', [PasswordResetController::class, 'request'])
    ->name('password.request');

Route::post('/password/forgot', [PasswordResetController::class, 'email'])
    ->name('password.email');

Route::get('/password/reset/{token}', [PasswordResetController::class, 'resetForm'])
    ->name('password.reset');

Route::post('/password/reset', [PasswordResetController::class, 'reset'])
    ->name('password.update');

// Home Route
Route::get('/', [Homecontroller::class, 'index'])->name('home');

// Artikel Routes
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::middleware(['auth'])->group(function () {

    // Dashboard utama user
    Route::get('/dashboard-user', [DashboardUserController::class, 'index'])
        ->name('dashboard.user');

    // FORM EDIT PROFIL USER
    Route::get('/dashboard-user/profile/edit', [ProfileController::class, 'edit'])
        ->name('ProfileUser.edit');

    // UPDATE PROFIL USER
    Route::patch('/dashboard-user/profile', [ProfileController::class, 'update'])
        ->name('ProfileUser.update');

    // UPDATE PASSWORD USER
    Route::patch('/dashboard-user/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('ProfileUser.password.update');

    // HAPUS AKUN
    Route::delete('/dashboard-user/profile', [ProfileController::class, 'destroy'])
        ->name('ProfileUser.destroy');

    //Route Khusus Tanda Tangan
    Route::patch('/dashboard-user/profile/signature', [ProfileController::class, 'updateSignature'])
        ->name('ProfileUser.signature.update');

     Route::get('/pengajuan/pilih-skema', [PengajuanSkemaController::class, 'pilihSkema'])
        ->name('pengajuan.pilih-skema');

    // Route untuk create pengajuan (setelah pilih skema)
    Route::get('/pengajuan/create/{program}', [PengajuanSkemaController::class, 'create'])
        ->name('pengajuan.create');

    Route::post('/pengajuan/store', [PengajuanSkemaController::class, 'store'])
        ->name('pengajuan.store');

    Route::get('/pengajuan/{id}', [PengajuanSkemaController::class, 'show'])
        ->name('pengajuan.show');

    Route::post('/pengajuan/draft', [PengajuanSkemaController::class, 'draft'])
        ->name('pengajuan.draft');

    Route::delete('/pengajuan/{id}', [PengajuanSkemaController::class, 'destroy'])
        ->name('pengajuan.destroy');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/latest', [NotificationController::class, 'getLatest'])->name('notifications.latest');

    // Pembayaran routes (User)
    Route::get('/pembayaran/{pengajuanId}', [\App\Http\Controllers\PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{pengajuanId}/upload', [\App\Http\Controllers\PembayaranController::class, 'upload'])->name('pembayaran.upload');

});

//Admin Routes
Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {
// Dashboard Admin Route
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD Program Pelatihan
        Route::resource('program-pelatihan', ProgramPelatihanController::class);
        // CRUD Asesi
        Route::resource('asesi', AsesiController::class);
        Route::resource('berita' , AdminBeritaController::class);

        // Pengajuan Management (Admin Only)
        Route::middleware('admin')->group(function () {
            Route::get('/pengajuan', [\App\Http\Controllers\Admin\PengajuanController::class, 'index'])
                ->name('pengajuan.index');
            Route::get('/pengajuan/{id}', [\App\Http\Controllers\Admin\PengajuanController::class, 'show'])
                ->name('pengajuan.show');
            Route::post('/pengajuan/{id}/approve', [\App\Http\Controllers\Admin\PengajuanController::class, 'approve'])
                ->name('pengajuan.approve');
            Route::post('/pengajuan/{id}/reject', [\App\Http\Controllers\Admin\PengajuanController::class, 'reject'])
                ->name('pengajuan.reject');
            
            // Pembayaran Management (Admin)
            Route::get('/pembayaran', [\App\Http\Controllers\Admin\PembayaranController::class, 'index'])
                ->name('pembayaran.index');
            Route::get('/pembayaran/{id}/detail', [\App\Http\Controllers\Admin\PembayaranController::class, 'show'])
                ->name('pembayaran.show');
            Route::post('/pembayaran/{id}/verify', [\App\Http\Controllers\Admin\PembayaranController::class, 'verify'])
                ->name('pembayaran.verify');
            Route::post('/pembayaran/{id}/reject', [\App\Http\Controllers\Admin\PembayaranController::class, 'reject'])
                ->name('pembayaran.reject');
        });
    });




