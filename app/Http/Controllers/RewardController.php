<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Redemption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    // ============= USER STORE =============
    // User store page
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $rewards = Reward::where('is_active', true)
            ->orderBy('cost')
            ->paginate(9);

        // Latest redemption status per reward for this user
        $latestRedemptions = Redemption::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get()
            ->keyBy('reward_id');

        return view('store.index', compact('rewards', 'user', 'latestRedemptions'));
    }

    // User redeem action
    public function redeem(Reward $reward)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$reward->is_active) {
            return back()->with('error', 'Hadiah tidak tersedia.');
        }

        if ($reward->stock <= 0) {
            return back()->with('error', 'Stok hadiah habis.');
        }

        if ($user->xp < $reward->cost) {
            return back()->with('error', 'Poin kamu tidak cukup.');
        }

        DB::transaction(function () use ($user, $reward) {
            // Lock rows to prevent race condition
            $reward->refresh();
            if ($reward->stock <= 0) {
                throw new \Exception('Stok habis.');
            }
            if ($user->xp < $reward->cost) {
                throw new \Exception('Poin tidak cukup.');
            }

            // Kurangi stok dan poin user
            $reward->decrement('stock', 1);
            $user->decrement('xp', $reward->cost);

            Redemption::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'status' => 'approved',
            ]);

            // Auto-equip frame if user doesn't have active frame yet
            if (!$user->active_profile_frame_id) {
                $user->active_profile_frame_id = $reward->id;
                $user->save();
            }
        });

        $autoEquipped = !Auth::user()->active_profile_frame_id;
        $message = "🎁 Selamat! Frame \"{$reward->name}\" berhasil dibuka!";
        if ($autoEquipped) {
            $message .= " Frame sudah otomatis terpasang di kartu kamu. ✨";
        } else {
            $message .= " Kunjungi Profile untuk mengaktifkan frame baru.";
        }

        return back()->with('success', $message);
    }

    // ============= ADMIN REWARD CRUD =============
    public function adminRewardsIndex()
    {
        $rewards = Reward::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.rewards.index', compact('rewards'));
    }

    public function adminRewardsCreate()
    {
        return view('admin.rewards.create');
    }

    public function adminRewardsStore(Request $request)
    {
        // Normalisasi checkbox menjadi boolean
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|integer|min:1',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'border_color' => 'nullable|string|max:100',
            'glow_style' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $data['icon'] = $data['icon'] ?: '🎁';
        $data['is_active'] = $request->boolean('is_active');

        Reward::create($data);

        return redirect()->route('admin.rewards.index')->with('success', '✨ Frame cosmetic berhasil ditambahkan!');
    }

    public function adminRewardsEdit(Reward $reward)
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    public function adminRewardsUpdate(Request $request, Reward $reward)
    {
        // Normalisasi checkbox menjadi boolean
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|integer|min:1',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'border_color' => 'nullable|string|max:100',
            'glow_style' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $data['icon'] = $data['icon'] ?: '🎁';
        $data['is_active'] = $request->boolean('is_active');

        $reward->update($data);

        return redirect()->route('admin.rewards.index')->with('success', '✏️ Frame cosmetic berhasil diperbarui!');
    }

    public function adminRewardsDestroy(Reward $reward)
    {
        $reward->delete();
        return redirect()->route('admin.rewards.index')->with('success', '🗑️ Hadiah berhasil dihapus!');
    }

    // ============= ADMIN REDEMPTIONS =============
    // Admin: list pending redemptions
    public function adminIndex()
    {
        $pendingRedemptions = Redemption::with('user', 'reward')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.redemptions.index', compact('pendingRedemptions'));
    }

    public function adminApprove($id)
    {
        $redemption = Redemption::with('user', 'reward')->findOrFail($id);

        if ($redemption->status !== 'pending') {
            return back()->with('error', 'Redeem sudah diproses.');
        }

        $redemption->update(['status' => 'approved']);

        return back()->with('success', "✅ Penukaran hadiah \"{$redemption->reward->name}\" disetujui!");
    }

    public function adminReject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500'
        ]);

        $redemption = Redemption::with('user', 'reward')->findOrFail($id);

        if ($redemption->status !== 'pending') {
            return back()->with('error', 'Redeem sudah diproses.');
        }

        DB::transaction(function () use ($redemption, $request) {
            $redemption->update([
                'status' => 'rejected',
                'admin_note' => $request->admin_note,
            ]);

            // Kembalikan stok dan poin user
            $redemption->reward->increment('stock', 1);
            $redemption->user->increment('xp', $redemption->reward->cost);
        });

        return back()->with('success', "❌ Penukaran hadiah \"{$redemption->reward->name}\" ditolak dan poin dikembalikan.");
    }
}
