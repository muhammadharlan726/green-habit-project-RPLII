<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🚀 Manage Missions</h1>
            <p class="text-gray-600 text-sm mt-1">Kelola semua misi yang tersedia</p>
        </div>
        <a href="{{ route('admin.missions.create') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Add New Mission
        </a>
    </div>

    <!-- Daily Missions Section -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-lg shadow-lg">
                <span class="text-2xl">📅</span>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daily Missions (Misi Harian)</h2>
                <p class="text-gray-600 text-sm">Misi yang dapat diambil setiap hari</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $dailyMissions = $missions->where('frequency', 'daily');
            @endphp
            
            @forelse($dailyMissions as $mission)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-bold text-gray-800 flex-1">{{ $mission->title }}</h3>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold whitespace-nowrap ml-2">
                                ⭐ {{ $mission->points_reward }} XP
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $mission->description }}</p>
                        
                        <div class="flex items-center flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-green-100 text-green-800 font-semibold">
                                📅 Daily
                            </span>
                            @if($mission->requires_evidence)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-red-100 text-red-800 font-semibold">
                                    📸 Evidence
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-800 font-semibold">
                                    ✅ Auto
                                </span>
                            @endif
                        </div>

                        <div class="flex gap-2 pt-4 border-t">
                            <a href="{{ route('admin.missions.edit', $mission) }}" class="flex-1 px-4 py-2 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-center text-sm font-semibold">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.missions.destroy', $mission) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus misi ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-sm font-semibold">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 bg-white rounded-lg shadow">
                    <p class="text-gray-500">Belum ada misi harian</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Weekly Missions Section -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-lg shadow-lg">
                <span class="text-2xl">📆</span>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Weekly Missions (Misi Mingguan)</h2>
                <p class="text-gray-600 text-sm">Misi yang dapat diambil setiap minggu</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $weeklyMissions = $missions->where('frequency', 'weekly');
            @endphp
            
            @forelse($weeklyMissions as $mission)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-bold text-gray-800 flex-1">{{ $mission->title }}</h3>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold whitespace-nowrap ml-2">
                                ⭐ {{ $mission->points_reward }} XP
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $mission->description }}</p>
                        
                        <div class="flex items-center flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800 font-semibold">
                                📆 Weekly
                            </span>
                            @if($mission->requires_evidence)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-red-100 text-red-800 font-semibold">
                                    📸 Evidence
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-800 font-semibold">
                                    ✅ Auto
                                </span>
                            @endif
                        </div>

                        <div class="flex gap-2 pt-4 border-t">
                            <a href="{{ route('admin.missions.edit', $mission) }}" class="flex-1 px-4 py-2 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-center text-sm font-semibold">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.missions.destroy', $mission) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus misi ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-sm font-semibold">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 bg-white rounded-lg shadow">
                    <p class="text-gray-500">Belum ada misi mingguan</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($missions->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-gray-500 font-semibold">Tidak ada misi sama sekali</p>
        </div>
    @endif
</x-admin-layout>
