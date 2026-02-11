<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">🏆 Leaderboard</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Peringkat pemain berdasarkan XP</p>
    </div>

    <!-- Leaderboard Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-2 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase w-12 sm:w-16">Rank</th>
                        <th class="px-2 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Player</th>
                        <th class="px-2 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase hidden sm:table-cell">Email</th>
                        <th class="px-2 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">XP</th>
                        <th class="px-2 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase hidden md:table-cell">Missions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($leaderboard as $index => $user)
                        <tr class="hover:bg-gray-50 transition {{ $index < 3 ? 'bg-gray-50' : '' }}">
                            <td class="px-2 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center justify-center w-8 sm:w-12 h-8 sm:h-12 rounded-full font-bold text-white text-sm sm:text-lg
                                    @if($index === 0) bg-yellow-400
                                    @elseif($index === 1) bg-gray-400
                                    @elseif($index === 2) bg-orange-400
                                    @else bg-green-200 text-green-800
                                    @endif">
                                    @if($index === 0) 🥇
                                    @elseif($index === 1) 🥈
                                    @elseif($index === 2) 🥉
                                    @else #{{ $index + 1 }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-7 h-7 sm:w-10 sm:h-10 rounded-full object-cover border border-gray-300">
                                    @else
                                        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 line-clamp-1">{{ $user->name }}</p>
                                        @if($user->is_admin)
                                            <span class="text-xs bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full font-bold">👑 Admin</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 sm:px-6 py-3 sm:py-4 text-gray-600 hidden sm:table-cell line-clamp-1">{{ $user->email }}</td>
                            <td class="px-2 sm:px-6 py-3 sm:py-4">
                                <span class="inline-flex items-center gap-1 px-2 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold bg-yellow-100 text-yellow-800">
                                    ⭐ {{ number_format($user->xp) }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-6 py-3 sm:py-4 text-gray-600 hidden md:table-cell text-xs sm:text-sm">
                                {{ $user->missionUsers()->where('status', 'completed')->count() }} missions
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data leaderboard
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $leaderboard->links() }}
    </div>
</x-admin-layout>
