<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-green-200 flex items-center gap-2">
                    Selamat datang kembali, 
                    <span class="inline-block animate-wave">👋</span>
                </p>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-green-200 via-white to-green-200 bg-clip-text text-transparent leading-tight flex items-center gap-3">
                    {{ $user->name }}
                    <span class="text-xs px-3 py-1.5 rounded-full {{ $user->level_color }} text-white font-bold shadow-lg animate-pulse-slow">{{ $user->level_name }}</span>
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-green-900 to-emerald-900 py-10 relative overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-72 h-72 bg-green-600 rounded-full mix-blend-lighten filter blur-3xl animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-emerald-600 rounded-full mix-blend-lighten filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-teal-600 rounded-full mix-blend-lighten filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            {{-- Notifications --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    ❌ {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Hero & Stats --}}
            @php
                $activeFrame = $user->activeFrame;
                $frameBorderClass = $activeFrame ? $activeFrame->frame_border_class : 'border-2 border-green-100';
                $frameGlowClass = $activeFrame ? $activeFrame->frame_glow_class : '';
            @endphp
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 text-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex flex-col gap-4 relative overflow-hidden {{ $frameBorderClass }} {{ $frameGlowClass }}">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent shimmer"></div>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-white bg-opacity-20 flex items-center justify-center text-2xl font-bold shadow-inner">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-green-100">Progress XP kamu</p>
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold">{{ $user->xp }} XP</h3>
                                <span class="text-sm font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">Target 1000 XP</span>
                            </div>
                        </div>
                    </div>
                    @php $xpPercent = min(($user->xp / 1000) * 100, 100); @endphp
                    <div class="w-full bg-white bg-opacity-20 rounded-full h-3 overflow-hidden shadow-inner" x-data="{ xp: {{ (int) $xpPercent }} }">
                        <div class="bg-gradient-to-r from-yellow-200 via-white to-yellow-200 h-3 rounded-full transition-all duration-700 ease-out shadow-lg" :style="{ width: xp + '%', boxShadow: '0 0 10px rgba(255, 255, 255, 0.6)' }"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 relative z-10">
                        <div class="bg-white bg-opacity-15 rounded-xl p-3 backdrop-blur shadow-sm hover:bg-opacity-25 transition-all duration-300 border border-white/20">
                            <p class="text-xs text-green-100">Misi Tersedia</p>
                            <p class="text-2xl font-extrabold">{{ $missions->count() }}</p>
                        </div>
                        <div class="bg-white bg-opacity-15 rounded-xl p-3 backdrop-blur shadow-sm hover:bg-opacity-25 transition-all duration-300 border border-white/20">
                            <p class="text-xs text-green-100">Misi Selesai</p>
                            <p class="text-2xl font-extrabold text-yellow-200">{{ $user->missions()->wherePivot('status', 'approved')->count() }}</p>
                        </div>
                        <div class="bg-white bg-opacity-15 rounded-xl p-3 backdrop-blur shadow-sm hover:bg-opacity-25 transition-all duration-300 border border-white/20">
                            <p class="text-xs text-green-100">Level</p>
                            <p class="text-2xl font-extrabold">{{ $user->level_name }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg hover:shadow-xl p-6 {{ $frameBorderClass }} {{ $frameGlowClass }} hover:border-green-300 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden @if($activeFrame) {{ $activeFrame->megamendung_pattern }} @if($activeFrame && $activeFrame->rarity === 'legendary') megamendung-border-wave @endif @else bg-white bg-opacity-95 backdrop-blur-sm @endif">
                    {{-- Content --}}
                    <div class="relative z-10">
                        <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-14 h-14 rounded-full object-cover border-2 border-green-100 flex-shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xl flex-shrink-0">👤</div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="text-lg font-bold text-gray-800 flex items-center gap-2">Aktif <span class="text-green-500 text-base">●</span></p>
                            </div>
                        </div>
                        @if($user->streak > 0)
                            <div class="flex flex-col items-center animate-pulse-slow flex-shrink-0">
                                <span class="text-4xl drop-shadow-lg">🔥</span>
                                <span class="text-xs font-bold bg-gradient-to-r from-orange-500 to-red-600 bg-clip-text text-transparent">{{ $user->streak }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                        <div class="p-3 rounded-lg bg-gray-50 border border-gray-100">
                            <p class="text-xs text-gray-400">Email</p>
                            <p class="font-semibold text-gray-800 truncate text-xs">{{ $user->email }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-gray-50 border border-gray-100">
                            <p class="text-xs text-gray-400">Level</p>
                            <p class="font-semibold text-gray-800 text-xs">{{ $user->level_name }}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            {{-- Missions --}}
            <div class="grid grid-cols-1 gap-6" x-data="{ 
                filter: 'all',
                matchFilter(frequency) {
                    if (this.filter === 'all') return true;
                    return frequency === this.filter;
                }
            }">
                <div class="space-y-4">
                    <div class="flex items-center justify-between flex-wrap gap-3 bg-white bg-opacity-90 backdrop-blur-sm rounded-2xl p-5 shadow-md border border-green-100 hover:shadow-lg transition-shadow duration-300">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">📜 Misi Tersedia</h3>
                            <p class="text-sm text-gray-600 mt-1">Pilih misi harian atau mingguan, kumpulkan XP lebih cepat.</p>
                        </div>
                        <div class="flex items-center gap-1 bg-gradient-to-r from-gray-50 to-green-50 rounded-full p-1.5 shadow-inner border border-green-200">
                            <button type="button" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300" :class="filter==='all' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-white/50'" @click="filter='all'">Semua</button>
                            <button type="button" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300" :class="filter==='daily' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-white/50'" @click="filter='daily'">Harian</button>
                            <button type="button" class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300" :class="filter==='weekly' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-white/50'" @click="filter='weekly'">Mingguan</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($missions as $mission)
                        <div class="group bg-white bg-opacity-95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-400 hover:-translate-y-2" x-show="matchFilter('{{ $mission->frequency }}')" x-transition style="background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(240,253,244,0.95) 100%);">
                            <div class="p-5 flex flex-col gap-4 h-full">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-800 leading-tight">{{ $mission->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap leading-relaxed">{{ Str::limit($mission->description, 100) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-300 shadow-md group-hover:shadow-lg transition-shadow">⭐ {{ $mission->points_reward }} XP</span>
                                        <div class="mt-2 text-[11px] text-gray-500 uppercase font-semibold">{{ $mission->frequency }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($mission->requires_evidence)
                                        <span class="text-[11px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-bold border border-indigo-200">📸 Wajib Bukti</span>
                                    @else
                                        <span class="text-[11px] bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-bold border border-gray-200">⚡ Tanpa Bukti</span>
                                    @endif
                                </div>

                                @php
                                    $taken = null;
                                    if ($mission->frequency === 'daily') {
                                        $taken = Auth::user()->missions()
                                            ->where('mission_id', $mission->id)
                                            ->whereDate('mission_user.created_at', \Carbon\Carbon::today())
                                            ->first();
                                    } else {
                                        $taken = Auth::user()->missions()
                                            ->where('mission_id', $mission->id)
                                            ->whereBetween('mission_user.created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])
                                            ->first();
                                    }
                                @endphp

                                <div class="mt-auto pt-3 border-t border-gray-100 space-y-3">
                                    @if($taken && $taken->pivot->status == 'in_progress')
                                        @if($mission->requires_evidence)
                                            <div class="bg-indigo-50 p-3 rounded-lg border border-indigo-100">
                                                <form action="{{ route('missions.complete', $mission->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <label class="block mb-2 text-xs font-bold text-indigo-800">📸 Upload Bukti Foto</label>
                                                    <input type="file" name="evidence" required class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 mb-3 bg-white border border-indigo-200 rounded cursor-pointer" />
                                                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white text-xs font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-1 transition-all duration-300 shadow-md hover:shadow-lg active:scale-95">Kirim Bukti & Selesai</button>
                                                </form>
                                            </div>
                                        @else
                                            <form action="{{ route('missions.complete', $mission->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-1 transition-all duration-300 shadow-md hover:shadow-lg active:scale-95">✅ Langsung Selesaikan</button>
                                            </form>
                                        @endif
                                    @elseif($taken && $taken->pivot->status == 'pending')
                                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                            <div class="flex items-center gap-2 mb-1 text-xs font-bold text-yellow-700">⏳ Menunggu Persetujuan Admin</div>
                                            @if($taken->pivot->evidence)
                                                <a href="{{ asset('storage/' . $taken->pivot->evidence) }}" target="_blank" class="text-xs text-blue-600 hover:underline font-semibold">📸 Lihat Bukti</a>
                                            @endif
                                        </div>
                                    @elseif($taken && $taken->pivot->status == 'approved')
                                        <div class="p-3 bg-green-50 rounded-lg border border-green-200 flex items-center justify-between">
                                            <span class="text-green-700 font-bold text-sm flex items-center gap-1">✅ Misi Selesai</span>
                                            @if($taken->pivot->evidence)
                                                <a href="{{ asset('storage/' . $taken->pivot->evidence) }}" target="_blank" class="text-xs text-blue-600 hover:underline font-semibold">Lihat Foto</a>
                                            @endif
                                        </div>
                                    @elseif($taken && $taken->pivot->status == 'rejected')
                                        <div class="p-3 bg-red-50 rounded-lg border border-red-200 space-y-2">
                                            <span class="text-red-700 font-bold text-sm flex items-center gap-1">❌ Misi Ditolak</span>
                                            <button type="button" data-reason="{{ $taken->pivot->notes ?? 'Bukti tidak valid atau tidak sesuai.' }}" onclick="alert('Alasan Penolakan:\n\n' + this.getAttribute('data-reason'))" class="text-xs bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 px-3 rounded transition">💬 Lihat Alasan</button>
                                            @if($taken->pivot->evidence)
                                                <a href="{{ asset('storage/' . $taken->pivot->evidence) }}" target="_blank" class="text-xs text-blue-600 hover:underline font-semibold">📸 Lihat Bukti</a>
                                            @endif
                                        </div>
                                    @else
                                        <form action="{{ route('missions.take', $mission->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-xs font-bold py-2.5 px-4 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg active:scale-95">Ambil Misi</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-span-2 text-center py-10 bg-white rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-500">Belum ada misi baru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>