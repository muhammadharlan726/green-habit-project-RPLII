<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\User;
use App\Models\Guide;
use App\Services\MissionAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(MissionAssignmentService $assignmentService)
    {
        /** @var User $user */
        $user = Auth::user();

        // =========================================================
        // 1. CEK STATUS: APAKAH DIA ADMIN?
        // =========================================================
        // Jika kolom is_admin = 1, kita tendang dia ke Panel Admin.
        // User biasa tidak akan pernah melihat baris ini.
        if ($user->is_admin) {
            return redirect()->route('admin.index');
        }

        // =========================================================
        // 2. JIKA BUKAN ADMIN (PLAYER BIASA)
        // =========================================================
        // Di sini kita siapkan data untuk Dashboard Gameplay

        // A. Get assigned missions for user (3 daily + 2 weekly)
        $missions = $assignmentService->getAssignedMissions($user);

        // B. Tampilkan View 'dashboard' (tampilan player)
        return view('dashboard', compact('missions', 'user'));
    }

    public function guides()
    {
        /** @var User $user */
        $user = Auth::user();

        // =========================================================
        // CEK STATUS: APAKAH DIA ADMIN?
        // =========================================================
        if ($user->is_admin) {
            return redirect()->route('admin.guides.index');
        }

        // =========================================================
        // TAMPILKAN SEMUA GUIDES UNTUK USER BIASA
        // =========================================================
        $guides = Guide::orderBy('created_at', 'desc')->paginate(9);

        return view('guides.index', compact('guides', 'user'));
    }

    public function leaderboard()
    {
        /** @var User $user */
        $user = Auth::user();

        // =========================================================
        // CEK STATUS: APAKAH DIA ADMIN?
        // =========================================================
        if ($user->is_admin) {
            return redirect()->route('admin.index');
        }

        // =========================================================
        // AMBIL SEMUA USER UNTUK LEADERBOARD
        // =========================================================
        $leaderboard = User::orderBy('xp', 'desc')->get();

        return view('leaderboard', compact('leaderboard', 'user'));
    }
}