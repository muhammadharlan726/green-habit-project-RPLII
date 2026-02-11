<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📊 Activity History</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Lihat semua aktivitas user di sistem</p>
    </div>

    <!-- Activity Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Time</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Player</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase hidden sm:table-cell">Mission</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Status</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">XP</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="text-xs sm:text-sm text-gray-800 font-medium">{{ $activity->updated_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $activity->updated_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    @if($activity->user_avatar)
                                        <img src="{{ asset('storage/' . $activity->user_avatar) }}" alt="{{ $activity->user_name }}" class="w-6 h-6 sm:w-8 sm:h-8 rounded-full object-cover border border-gray-300">
                                    @else
                                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($activity->user_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="font-semibold text-gray-800 line-clamp-1">{{ $activity->user_name }}</span>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-600 hidden sm:table-cell text-xs sm:text-sm">{{ Str::limit($activity->mission_title, 30) }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-bold 
                                    @if($activity->status === 'completed') bg-green-100 text-green-800
                                    @elseif($activity->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($activity->status === 'completed') ✅
                                    @elseif($activity->status === 'pending') ⏳
                                    @else ❌
                                    @endif
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                    ⭐ +{{ $activity->points_reward }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada aktivitas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $activities->links() }}
    </div>
</x-admin-layout>
