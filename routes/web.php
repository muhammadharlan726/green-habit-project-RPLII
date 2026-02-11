<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\RewardController;
use App\Models\User;     // Model User untuk Leaderboard Depan
use App\Models\Mission;  // Model Mission (Opsional, tapi baik untuk dipanggil)
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. HALAMAN DEPAN (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    // A. Ambil 3 Player Terkuat (XP Tertinggi) untuk Hall of Fame
    $topPlayers = User::orderBy('xp', 'desc')->take(3)->get();
    
    // B. Hitung Total User yang sudah daftar
    $totalUsers = User::count();

    // C. Hitung Total XP di seluruh server (Statistik Komunitas)
    $totalXp = User::sum('xp');

    // Kirim semua data ke view 'welcome'
    return view('welcome', compact('topPlayers', 'totalUsers', 'totalXp'));
});

// ==========================================
// 2. DASHBOARD (Redirect setelah Login)
// ==========================================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 2B. STORE / HADIAH
Route::get('/store', [RewardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('store.index');
Route::post('/store/redeem/{reward}', [RewardController::class, 'redeem'])
    ->middleware(['auth', 'verified'])
    ->name('store.redeem');

// 2C. LEADERBOARD
Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])
    ->middleware(['auth', 'verified'])
    ->name('leaderboard');

// ==========================================
// 2B. GUIDES PAGE (User biasa bisa lihat)
// ==========================================
Route::get('/guides', [DashboardController::class, 'guides'])
    ->middleware(['auth', 'verified'])
    ->name('guides.index');

// ==========================================
// 3. AREA MEMBER (Harus Login)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // --- FITUR PROFIL USER ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/frame', [ProfileController::class, 'updateFrame'])->name('profile.update-frame');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- GAMEPLAY (Pemain Mengambil & Menyelesaikan Misi) ---
    // Route ini harus di luar grup 'admin' supaya user biasa bisa main
    Route::post('/missions/{id}/take', [MissionController::class, 'take'])->name('missions.take');
    Route::post('/missions/{id}/complete', [MissionController::class, 'complete'])->name('missions.complete');

    // ==========================================
    // 4. 🔥 AREA KHUSUS ADMIN 🔥
    // ==========================================
    Route::middleware('admin')->group(function () {
        // Dashboard Admin
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
        
        // User Management (CRUD)
        Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
        Route::get('/admin/users/create', [AdminController::class, 'usersCreate'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'usersStore'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');
        Route::delete('/admin/users/bulk', [AdminController::class, 'usersBulkDestroy'])->name('admin.users.bulk-destroy');
        
        // Mission Management (CRUD)
        Route::get('/admin/missions', [AdminController::class, 'missionsIndex'])->name('admin.missions.index');
        Route::get('/admin/missions/create', [AdminController::class, 'missionsCreate'])->name('admin.missions.create');
        Route::post('/admin/missions', [AdminController::class, 'missionsStore'])->name('admin.missions.store');
        Route::get('/admin/missions/{mission}/edit', [AdminController::class, 'missionsEdit'])->name('admin.missions.edit');
        Route::put('/admin/missions/{mission}', [AdminController::class, 'missionsUpdate'])->name('admin.missions.update');
        Route::delete('/admin/missions/{mission}', [AdminController::class, 'missionsDestroy'])->name('admin.missions.destroy');

        // Guides Management (CRUD)
        Route::get('/admin/guides', [AdminController::class, 'guidesIndex'])->name('admin.guides.index');
        Route::get('/admin/guides/create', [AdminController::class, 'guidesCreate'])->name('admin.guides.create');
        Route::post('/admin/guides', [AdminController::class, 'guidesStore'])->name('admin.guides.store');
        Route::get('/admin/guides/{guide}/edit', [AdminController::class, 'guidesEdit'])->name('admin.guides.edit');
        Route::put('/admin/guides/{guide}', [AdminController::class, 'guidesUpdate'])->name('admin.guides.update');
        Route::delete('/admin/guides/{guide}', [AdminController::class, 'guidesDestroy'])->name('admin.guides.destroy');

        // Approvals Management
        Route::get('/admin/approvals', [AdminController::class, 'approvalsIndex'])->name('admin.approvals.index');
        Route::post('/admin/approvals/{id}/approve', [AdminController::class, 'approvalsApprove'])->name('admin.approvals.approve');
        Route::post('/admin/approvals/{id}/reject', [AdminController::class, 'approvalsReject'])->name('admin.approvals.reject');

        // Reward Management (Store CRUD)
        Route::get('/admin/rewards', [RewardController::class, 'adminRewardsIndex'])->name('admin.rewards.index');
        Route::get('/admin/rewards/create', [RewardController::class, 'adminRewardsCreate'])->name('admin.rewards.create');
        Route::post('/admin/rewards', [RewardController::class, 'adminRewardsStore'])->name('admin.rewards.store');
        Route::get('/admin/rewards/{reward}/edit', [RewardController::class, 'adminRewardsEdit'])->name('admin.rewards.edit');
        Route::put('/admin/rewards/{reward}', [RewardController::class, 'adminRewardsUpdate'])->name('admin.rewards.update');
        Route::delete('/admin/rewards/{reward}', [RewardController::class, 'adminRewardsDestroy'])->name('admin.rewards.destroy');

        // Redemptions Management (Store)
        Route::get('/admin/redemptions', [RewardController::class, 'adminIndex'])->name('admin.redemptions.index');
        Route::post('/admin/redemptions/{id}/approve', [RewardController::class, 'adminApprove'])->name('admin.redemptions.approve');
        Route::post('/admin/redemptions/{id}/reject', [RewardController::class, 'adminReject'])->name('admin.redemptions.reject');
        
        // Analytics
        Route::get('/admin/history', [AdminController::class, 'history'])->name('admin.history');
        Route::get('/admin/leaderboard', [AdminController::class, 'leaderboard'])->name('admin.leaderboard');
    });
});

require __DIR__.'/auth.php';