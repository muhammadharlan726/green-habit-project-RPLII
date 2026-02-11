<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; // Wajib
use Illuminate\Support\Str; // Wajib
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validasi Foto (Opsional, Max 2MB)
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();
        
        // Isi data standar (nama, email)
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 🔥 LOGIKA UPLOAD AVATAR (ANTI-ERROR VERSION) 🔥
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            if ($file && $file->isValid()) {
                // 1. Hapus avatar lama jika ada (biar server gak penuh sampah)
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // 2. Buat nama unik
                $extension = $file->getClientOriginalExtension();
                $filename = 'avatars/' . time() . '_' . Str::random(10) . '.' . $extension;

                // 3. Simpan pakai metode manual (baca & tulis)
                try {
                    Storage::disk('public')->put($filename, file_get_contents($file));
                    
                    // Simpan path ke user
                    $user->avatar = $filename;

                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal upload avatar: ' . $e->getMessage());
                }
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's active profile frame.
     */
    public function updateFrame(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'active_profile_frame_id' => 'nullable|exists:rewards,id',
        ]);

        $user = $request->user();

        // If frame selected, verify user has unlocked it
        if ($validated['active_profile_frame_id']) {
            $hasFrame = $user->unlockedFrames()
                ->whereHas('reward', function($q) use ($validated) {
                    $q->where('id', $validated['active_profile_frame_id']);
                })
                ->exists();

            if (!$hasFrame) {
                return Redirect::back()->with('error', 'Frame belum di-unlock!');
            }
        }

        $user->active_profile_frame_id = $validated['active_profile_frame_id'];
        $user->save();

        return Redirect::route('profile.edit')->with('frame_updated', 'frame-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}