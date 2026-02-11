<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mission;
use App\Models\Guide;
use App\Models\MissionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * DASHBOARD - TAMPILAN OVERVIEW
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_missions' => Mission::count(),
            'total_xp' => User::sum('xp'),
            'completions' => DB::table('mission_user')->where('status', 'approved')->count(),
        ];

        $activities = DB::table('mission_user')
            ->join('users', 'mission_user.user_id', '=', 'users.id')
            ->join('missions', 'mission_user.mission_id', '=', 'missions.id')
            ->select(
                'mission_user.*',
                'users.name as user_name',
                'users.avatar as user_avatar',
                'missions.title as mission_title',
                'missions.points_reward'
            )
            ->where('mission_user.status', 'approved')
            ->orderBy('mission_user.updated_at', 'desc')
            ->limit(20)
            ->get();

        $leaderboard = User::orderBy('xp', 'desc')->limit(10)->get();

        return view('admin.index', compact('stats', 'activities', 'leaderboard'));
    }

    // ============ USER MANAGEMENT ============

    /**
     * LIST USERS
     */
    public function usersIndex(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc') === 'asc' ? 'asc' : 'desc';

        // Whitelist sortable columns
        $sortable = [
            'name',
            'email',
            'xp',
            'created_at',
            'is_admin',
        ];

        if (!in_array($sort, $sortable, true)) {
            $sort = 'created_at';
        }

        $query = User::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role === 'admin', fn ($q) => $q->where('is_admin', true))
            ->when($role === 'player', fn ($q) => $q->where('is_admin', false));

        $previewUsers = (clone $query)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'name', 'email', 'xp', 'is_admin', 'created_at']);

        $users = $query
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'previewUsers', 'search', 'role', 'sort', 'direction'));
    }

    /**
     * SHOW CREATE USER FORM
     */
    public function usersCreate()
    {
        return view('admin.users.create');
    }

    /**
     * STORE USER
     */
    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', '👤 User berhasil ditambahkan!');
    }

    /**
     * SHOW EDIT USER FORM
     */
    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * UPDATE USER
     */
    public function usersUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
            'xp' => 'integer|min:0',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', '✏️ User berhasil diperbarui!');
    }

    /**
     * DELETE USER
     */
    public function usersDestroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->back()->with('success', '🗑️ User berhasil dihapus!');
    }

    /**
     * BULK DELETE USERS
     */
    public function usersBulkDestroy(Request $request)
    {
        $ids = collect($request->input('ids', []))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->reject(fn ($id) => $id === Auth::id())
            ->values();

        if ($ids->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada user yang dipilih.');
        }

        User::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', '🗑️ Berhasil menghapus ' . $ids->count() . ' user.');
    }

    // ============ MISSION MANAGEMENT ============

    /**
     * LIST MISSIONS
     */
    public function missionsIndex()
    {
        $missions = Mission::orderBy('created_at', 'desc')->get();
        return view('admin.missions.index', compact('missions'));
    }

    /**
     * SHOW CREATE MISSION FORM
     */
    public function missionsCreate()
    {
        return view('admin.missions.create');
    }

    /**
     * STORE MISSION
     */
    public function missionsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'points_reward' => 'required|integer|min:1',
            'frequency' => 'required|in:daily,weekly',
            'requires_evidence' => 'boolean',
            'icon' => 'nullable|string',
        ]);

        $validated['requires_evidence'] = $request->has('requires_evidence');

        Mission::create($validated);

        return redirect()->route('admin.missions.index')->with('success', '🚀 Misi berhasil ditambahkan!');
    }

    /**
     * SHOW EDIT MISSION FORM
     */
    public function missionsEdit(Mission $mission)
    {
        return view('admin.missions.edit', compact('mission'));
    }

    /**
     * UPDATE MISSION
     */
    public function missionsUpdate(Request $request, Mission $mission)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'points_reward' => 'required|integer|min:1',
            'frequency' => 'required|in:daily,weekly',
            'requires_evidence' => 'boolean',
            'icon' => 'nullable|string',
        ]);

        $validated['requires_evidence'] = $request->has('requires_evidence');

        $mission->update($validated);

        return redirect()->route('admin.missions.index')->with('success', '✏️ Misi berhasil diperbarui!');
    }

    /**
     * DELETE MISSION
     */
    public function missionsDestroy(Mission $mission)
    {
        $mission->delete();
        return redirect()->back()->with('success', '🗑️ Misi berhasil dihapus!');
    }

    // ============ ANALYTICS ============

    /**
     * ACTIVITY HISTORY
     */
    public function history()
    {
        $perPage = 20;
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        
        // Count total activities (only approved missions)
        $total = DB::table('mission_user')
            ->join('users', 'mission_user.user_id', '=', 'users.id')
            ->join('missions', 'mission_user.mission_id', '=', 'missions.id')
            ->where('mission_user.status', 'approved')
            ->count();
        
        // Get paginated activities (only approved missions)
        $items = DB::table('mission_user')
            ->join('users', 'mission_user.user_id', '=', 'users.id')
            ->join('missions', 'mission_user.mission_id', '=', 'missions.id')
            ->where('mission_user.status', 'approved')
            ->select(
                'mission_user.*',
                'users.name as user_name',
                'users.avatar as user_avatar',
                'missions.title as mission_title',
                'missions.points_reward'
            )
            ->orderBy('mission_user.updated_at', 'desc')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get()
            ->map(function($activity) {
                $activity->updated_at = \Carbon\Carbon::parse($activity->updated_at);
                return $activity;
            });

        // Create paginator instance
        $activities = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );

        return view('admin.history', compact('activities'));
    }

    /**
     * LEADERBOARD
     */
    public function leaderboard()
    {
        $leaderboard = User::orderBy('xp', 'desc')->paginate(20);
        return view('admin.leaderboard', compact('leaderboard'));
    }

    /**
     * GUIDES MANAGEMENT
     */
    public function guidesIndex()
    {
        $guides = Guide::paginate(10);
        return view('admin.guides.index', compact('guides'));
    }

    public function guidesCreate()
    {
        return view('admin.guides.create');
    }

    public function guidesStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:10',
        ]);

        Guide::create($validated);
        return redirect()->route('admin.guides.index')->with('success', '📖 Panduan berhasil ditambahkan!');
    }

    public function guidesEdit(Guide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    public function guidesUpdate(Request $request, Guide $guide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:10',
        ]);

        $guide->update($validated);
        return redirect()->route('admin.guides.index')->with('success', '✏️ Panduan berhasil diperbarui!');
    }

    public function guidesDestroy(Guide $guide)
    {
        $guide->delete();
        return redirect()->route('admin.guides.index')->with('success', '🗑️ Panduan berhasil dihapus!');
    }

    /**
     * MISSION APPROVALS
     */
    public function approvalsIndex()
    {
        // Ambil data pending terbaru per user+mission saja (hindari duplikat)
        $pendingApprovals = DB::table('mission_user as mu')
            ->join('users as u', 'mu.user_id', '=', 'u.id')
            ->join('missions as m', 'mu.mission_id', '=', 'm.id')
            ->where('mu.status', 'pending')
            ->whereNotNull('mu.evidence')
            ->whereIn('mu.id', function ($q) {
                $q->select(DB::raw('MAX(id)'))
                    ->from('mission_user')
                    ->where('status', 'pending')
                    ->whereNotNull('evidence')
                    ->groupBy('user_id', 'mission_id');
            })
            ->select(
                'mu.id as pivot_id',
                'mu.user_id',
                'mu.mission_id',
                'mu.evidence',
                'mu.notes',
                'mu.status',
                'mu.created_at',
                'u.name as user_name',
                'u.email as user_email',
                'u.avatar as user_avatar',
                'm.title as mission_title',
                'm.description as mission_description',
                'm.points_reward'
            )
            ->orderBy('mu.created_at', 'desc')
            ->paginate(10);

        // Ambil data history (approved + rejected)
        $historyApprovals = DB::table('mission_user as mu')
            ->join('users as u', 'mu.user_id', '=', 'u.id')
            ->join('missions as m', 'mu.mission_id', '=', 'm.id')
            ->whereIn('mu.status', ['approved', 'rejected'])
            ->whereNotNull('mu.evidence')
            ->select(
                'mu.id as pivot_id',
                'mu.user_id',
                'mu.mission_id',
                'mu.evidence',
                'mu.notes',
                'mu.status',
                'mu.created_at',
                'mu.updated_at',
                'u.name as user_name',
                'u.email as user_email',
                'u.avatar as user_avatar',
                'm.title as mission_title',
                'm.description as mission_description',
                'm.points_reward'
            )
            ->orderBy('mu.updated_at', 'desc')
            ->paginate(10, ['*'], 'history_page');

        return view('admin.approvals.index', compact('pendingApprovals', 'historyApprovals'));
    }

    public function approvalsApprove($id)
    {
        // Ambil data pivot
        $pivot = DB::table('mission_user')->where('id', $id)->first();
        
        if (!$pivot) {
            return redirect()->route('admin.approvals.index')->with('error', 'Data tidak ditemukan!');
        }

        // Update status menjadi approved
        DB::table('mission_user')->where('id', $id)->update(['status' => 'approved']);
        
        // Ambil data mission untuk tahu berapa XP yang harus ditambahkan
        $mission = Mission::find($pivot->mission_id);
        
        // Tambah XP ke user
        $user = User::find($pivot->user_id);
        $user->increment('xp', $mission->points_reward);
        
        return redirect()->route('admin.approvals.index')->with('success', "✅ Misi \"{$mission->title}\" dari {$user->name} disetujui! +{$mission->points_reward} XP");
    }

    public function approvalsReject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        // Update status menjadi rejected dengan catatan
        DB::table('mission_user')->where('id', $id)->update([
            'status' => 'rejected',
            'notes' => $request->notes ?? 'Bukti tidak valid atau tidak sesuai.'
        ]);
        
        return redirect()->route('admin.approvals.index')->with('success', '❌ Misi berhasil ditolak!');
    }
}

