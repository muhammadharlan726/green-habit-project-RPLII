<x-admin-layout>
    <!-- Quick Actions (Responsive Grid) -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-4 sm:p-6 mb-8 w-full">
        <h3 class="font-bold text-white mb-4 text-base sm:text-lg">Quick Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 sm:p-4 rounded-lg bg-white bg-opacity-20 hover:bg-opacity-30 transition text-white font-semibold border-2 border-white border-opacity-30 text-sm sm:text-base">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                </svg>
                <span>Manage Users</span>
            </a>
            <a href="{{ route('admin.missions.index') }}" class="flex items-center gap-3 p-3 sm:p-4 rounded-lg bg-white bg-opacity-20 hover:bg-opacity-30 transition text-white font-semibold border-2 border-white border-opacity-30 text-sm sm:text-base">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                <span>Manage Missions</span>
            </a>
            <a href="{{ route('admin.leaderboard') }}" class="flex items-center gap-3 p-3 sm:p-4 rounded-lg bg-white bg-opacity-20 hover:bg-opacity-30 transition text-white font-semibold border-2 border-white border-opacity-30 text-sm sm:text-base">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span>Leaderboard</span>
            </a>
        </div>
    </div>

    <!-- Dashboard Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-green-100 text-xs sm:text-sm font-medium">Total Users</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                </div>
                <div class="text-green-200 flex-shrink-0">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Missions Card -->
        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-green-100 text-xs sm:text-sm font-medium">Total Missions</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $stats['total_missions'] }}</p>
                </div>
                <div class="text-green-200 flex-shrink-0">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total XP Card -->
        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-green-100 text-xs sm:text-sm font-medium">Total XP Distributed</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ number_format($stats['total_xp']) }}</p>
                </div>
                <div class="text-green-200 flex-shrink-0">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completions Card -->
        <div class="bg-gradient-to-br from-green-700 to-green-800 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-green-100 text-xs sm:text-sm font-medium">Mission Completions</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $stats['completions'] }}</p>
                </div>
                <div class="text-green-200 flex-shrink-0">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full">
            <div class="px-4 sm:px-6 py-4 border-b-2 border-green-600 bg-gradient-to-r from-green-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-base sm:text-lg">
                    📊 Recent Activities
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="bg-green-50 border-b">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left font-semibold text-green-800">Player</th>
                            <th class="px-3 sm:px-6 py-3 text-left font-semibold text-green-800">Mission</th>
                            <th class="px-3 sm:px-6 py-3 text-left font-semibold text-green-800">XP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($activities as $activity)
                            <tr class="hover:bg-green-50">
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-800 font-medium line-clamp-1">{{ $activity->user_name ?? 'Unknown User' }}</td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-600 line-clamp-1">{{ isset($activity->mission_title) ? Str::limit($activity->mission_title, 20) : 'Unknown Mission' }}</td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4"><span class="bg-green-100 text-green-800 px-2 sm:px-3 py-1 rounded-full text-xs font-bold">+{{ $activity->points_reward ?? 0 }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 sm:px-6 py-4 text-center text-gray-500 text-xs sm:text-sm">Tidak ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t bg-green-50">
                <a href="{{ route('admin.history') }}" class="text-green-600 hover:text-green-700 font-semibold text-xs sm:text-sm">Lihat semua →</a>
            </div>
        </div>

        <!-- Top Leaderboard -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full">
            <div class="px-4 sm:px-6 py-4 border-b-2 border-green-600 bg-gradient-to-r from-green-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-base sm:text-lg">
                    🏆 Top Leaderboard
                </h3>
            </div>
            <div class="divide-y max-h-96 overflow-y-auto">
                @forelse($leaderboard as $index => $user)
                    <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between hover:bg-green-50 transition gap-3">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full flex-shrink-0 {{ $index === 0 ? 'bg-green-500 text-white' : ($index === 1 ? 'bg-green-400 text-white' : ($index === 2 ? 'bg-green-300 text-white' : 'bg-gray-200 text-gray-700')) }} font-bold text-xs sm:text-sm">
                                #{{ $index + 1 }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-800 text-xs sm:text-base line-clamp-1">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-green-600 text-xs sm:text-sm">{{ $user->xp }} XP</p>
                        </div>
                    </div>
                @empty
                    <div class="px-4 sm:px-6 py-8 text-center text-gray-500 text-xs sm:text-sm">
                        Tidak ada data leaderboard
                    </div>
                @endforelse
            </div>
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t bg-green-50">
                <a href="{{ route('admin.leaderboard') }}" class="text-green-600 hover:text-green-700 font-semibold text-xs sm:text-sm">Lihat semua →</a>
            </div>
        </div>
    </div>
</x-admin-layout>
