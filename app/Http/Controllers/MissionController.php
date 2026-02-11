<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Wajib untuk penyimpanan
use Illuminate\Support\Str; // Wajib untuk nama file acak

class MissionController extends Controller
{
    // ==========================================
    // BAGIAN 1: CRUD UNTUK ADMIN
    // ==========================================

    public function index()
    {
        $missions = Mission::all();
        return view('admin.missions.index', compact('missions'));
    }

    public function create()
    {
        return view('admin.missions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'points_reward' => 'required|integer|min:1',
            'frequency' => 'required|in:daily,weekly',
            'requires_evidence' => 'required|boolean',
        ]);

        Mission::create([
            'title' => $request->title,
            'description' => $request->description,
            'points_reward' => $request->points_reward,
            'frequency' => $request->frequency,
            'requires_evidence' => $request->requires_evidence,
            'icon' => 'fa-star',
            'is_active' => true,
        ]);

        return redirect()->route('missions.index')
                         ->with('success', 'Misi berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $mission = Mission::findOrFail($id);
        return view('admin.missions.edit', compact('mission'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'points_reward' => 'required|integer|min:1',
            'frequency' => 'required|in:daily,weekly',
            'requires_evidence' => 'required|boolean',
        ]);

        $mission = Mission::findOrFail($id);
        $mission->update([
            'title' => $request->title,
            'description' => $request->description,
            'points_reward' => $request->points_reward,
            'frequency' => $request->frequency,
            'requires_evidence' => $request->requires_evidence,
        ]);

        return redirect()->route('missions.index')
                         ->with('success', 'Misi berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $mission = Mission::findOrFail($id);
        $mission->delete();

        return redirect()->route('missions.index')
                         ->with('success', 'Misi berhasil dihapus!');
    }

    public function show(string $id) {}


    // ==========================================
    // BAGIAN 2: FITUR GAMEPLAY (PLAYER)
    // ==========================================

    /**
     * PLAYER MENGAMBIL MISI
     */
    public function take(Request $request, $id)
    {
        $mission = Mission::findOrFail($id);
        /** @var User $user */
        $user = Auth::user();

        // Cek Logika Reset (Harian/Mingguan)
        $alreadyTaken = false;
        if ($mission->frequency == 'daily') {
            $alreadyTaken = $user->missions()
                                 ->where('mission_id', $id)
                                 ->whereDate('mission_user.created_at', now()->today())
                                 ->exists();
        } else {
            $alreadyTaken = $user->missions()
                                 ->where('mission_id', $id)
                                 ->whereBetween('mission_user.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                 ->exists();
        }

        if ($alreadyTaken) {
            return redirect()->back()->with('error', 'Misi ini sudah kamu ambil periode ini!');
        }

        $user->missions()->attach($id, ['status' => 'in_progress']);

        return redirect()->route('dashboard')->with('success', "🚀 Misi \"{$mission->title}\" berhasil diambil! Semangat menyelesaikannya!");
    }

    /**
     * PLAYER MENYELESAIKAN MISI (METODE MANUAL SAVE - ANTI ERROR WINDOWS)
     */
    public function complete(Request $request, $id)
    {
        $mission = Mission::findOrFail($id);
        /** @var User $user */
        $user = Auth::user();

        // 1. Validasi Input (Hanya jika butuh bukti)
        if ($mission->requires_evidence) {
            $request->validate([
                'evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
            ], [
                'evidence.required' => 'Wajib upload foto bukti!',
                'evidence.image' => 'File harus berupa gambar.',
            ]);
        }

        // 2. Cek status misi (harus in_progress)
        $missionRecord = $user->missions()
                              ->where('mission_id', $id)
                              ->wherePivot('status', 'in_progress')
                              ->latest('mission_user.created_at')
                              ->first();

        if (!$missionRecord) {
            return redirect()->back()->with('error', 'Misi tidak valid atau sudah selesai!');
        }

        // 3. PROSES UPLOAD FILE (MANUAL READ & WRITE)
        $filePath = null;

        if ($mission->requires_evidence) {
            $file = $request->file('evidence');

            // Kita gunakan isValid() untuk memastikan file terupload sempurna ke server
            if ($file && $file->isValid()) {
                
                // Buat nama file unik sendiri
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . Str::random(10) . '.' . $extension;
                $destinationPath = 'evidence/' . $filename;

                try {
                    // JURUS ANTI-ERROR: Baca konten file langsung, lalu tulis ke storage
                    // Ini membypass error path temporary Windows yang sering kosong
                    Storage::disk('public')->put($destinationPath, file_get_contents($file));
                    
                    // Set path untuk disimpan di database
                    $filePath = $destinationPath;

                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal menyimpan file: ' . $e->getMessage());
                }

            } else {
                return redirect()->back()->with('error', 'File tidak valid atau rusak saat upload.');
            }
        }

        // 4. Update Database
        // Jika misi butuh bukti foto, set status = 'pending' (menunggu approval admin)
        // Jika tidak butuh bukti, langsung 'approved'
        $newStatus = $mission->requires_evidence ? 'pending' : 'approved';
        
        $user->missions()->updateExistingPivot($id, [
            'status' => $newStatus,
            'evidence' => $filePath
        ]);

        // 5. Tambah XP hanya jika langsung approved (tidak butuh bukti)
        // Jika pending, XP akan ditambah saat admin approve
        if ($newStatus === 'approved') {
            // Increment XP
            $user->increment('xp', $mission->points_reward);
            
            // Update Streak
            $today = now()->toDateString();
            $lastStreakDate = $user->last_streak_date ? $user->last_streak_date->toDateString() : null;
            
            if ($lastStreakDate === $today) {
                // Sudah complete mission hari ini, jangan increment streak lagi
            } elseif ($lastStreakDate === now()->subDay()->toDateString()) {
                // Hari kemarin ada complete, increment streak
                $user->increment('streak');
            } else {
                // Reset streak dan mulai dari 1
                $user->streak = 1;
            }
            
            // Update last_streak_date
            $user->last_streak_date = $today;
            $user->save();
            
            return redirect()->route('dashboard')->with('success', "🎉 Selamat! Misi \"{$mission->title}\" selesai. Kamu dapat +{$mission->points_reward} XP! 🔥 Streak: {$user->streak}");
        } else {
            return redirect()->route('dashboard')->with('success', "✅ Bukti berhasil diupload! Menunggu persetujuan admin untuk misi \"{$mission->title}\".");
        }
    }
}