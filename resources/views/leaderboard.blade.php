<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl bg-gradient-to-r from-yellow-200 via-white to-yellow-200 bg-clip-text text-transparent leading-tight flex items-center gap-3">
            <span class="inline-block animate-pulse-slow">🏆</span>
            Leaderboard
            <span class="text-sm font-normal text-green-200">Top Pahlawan Bumi</span>
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-green-900 to-emerald-900 min-h-screen relative overflow-hidden">
        <!-- Animated Background Blobs -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-green-700 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-600 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-teal-700 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 relative z-10">

            {{-- User's Rank Card --}}
            @php
                $userRank = $leaderboard->search(function($u) { return $u->id === Auth::id(); }) + 1;
            @endphp
            <div class="bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 text-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent shimmer"></div>
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-14 h-14 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <div class="w-14 h-14 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-2xl font-bold shadow-lg">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-green-100">Peringkat Kamu</p>
                            <h3 class="text-2xl font-bold">#{{ $userRank }} dari {{ $leaderboard->count() }} Pahlawan</h3>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-green-100">Total XP</p>
                        <p class="text-3xl font-extrabold">{{ number_format($user->xp) }} XP</p>
                    </div>
                </div>
            </div>

            {{-- Top 3 Podium --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                @foreach($leaderboard->take(3) as $index => $topUser)
                @php
                    $podiumFrame = $topUser->activeFrame;
                    $podiumBorder = $podiumFrame ? $podiumFrame->frame_border_class : ($index === 0 ? 'border-4 border-yellow-400' : ($index === 1 ? 'border-2 border-gray-300' : 'border-2 border-orange-400'));
                    $podiumGlow = $podiumFrame ? $podiumFrame->frame_glow_class : '';
                @endphp
                <div class="group bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-300 hover:-translate-y-2 {{ $podiumBorder }} {{ $podiumGlow }} {{ $index === 0 ? 'md:order-2' : ($index === 1 ? 'md:order-1' : 'md:order-3') }} relative overflow-hidden\">
                    {{-- Megamendung Pattern for Top 1 Only --}}
                    @if($index === 0 && $podiumFrame)
                        <div class="absolute inset-0 {{ $podiumFrame->megamendung_pattern }} opacity-100 pointer-events-none rounded-2xl\"></div>
                    @endif
                    {{-- Content --}}
                    <div class="relative z-10\">
                    <div class="relative inline-block mb-4">
                        @if($topUser->avatar)
                            <img src="{{ asset('storage/' . $topUser->avatar) }}" class="w-20 h-20 rounded-full object-cover border-4 {{ $index === 0 ? 'border-yellow-400' : ($index === 1 ? 'border-gray-300' : 'border-orange-400') }}">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br {{ $index === 0 ? 'from-yellow-400 to-yellow-600' : ($index === 1 ? 'from-gray-300 to-gray-500' : 'from-orange-400 to-orange-600') }} flex items-center justify-center text-white text-2xl font-bold border-4 {{ $index === 0 ? 'border-yellow-400' : ($index === 1 ? 'border-gray-300' : 'border-orange-400') }}">
                                {{ substr($topUser->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full {{ $index === 0 ? 'bg-yellow-400' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-400') }} flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ $index + 1 }}
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 {{ $topUser->id == Auth::id() ? 'text-green-600' : '' }}">
                        {{ Str::limit($topUser->name, 18) }}
                        @if($topUser->id == Auth::id())<span class="text-xs">(Kamu)</span>@endif
                    </h3>
                    <p class="text-xs px-3 py-1 rounded-full inline-block {{ $topUser->level_color }} text-white font-bold mt-1">{{ $topUser->level_name }}</p>
                    <div class="mt-3">
                        <p class="text-2xl font-extrabold text-green-600">{{ number_format($topUser->xp) }} XP</p>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Full Leaderboard Table --}}
            <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-green-100">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-white to-green-50">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-green-700 bg-clip-text text-transparent flex items-center gap-2">
                        📊 Peringkat Lengkap
                        <span class="text-sm font-normal text-gray-500">({{ $leaderboard->count() }} Pahlawan)</span>
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Pahlawan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Level</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">XP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($leaderboard as $index => $lbUser)
                            @php
                                $rowFrame = $lbUser->activeFrame;
                                $rowGlow = ($rowFrame && $rowFrame->rarity === 'legendary') ? 'shadow-md shadow-orange-500/20' : '';
                            @endphp
                            <tr class="hover:bg-green-50 transition-all duration-200 {{ $rowGlow }} {{ $lbUser->id == Auth::id() ? 'bg-gradient-to-r from-green-100 to-emerald-100 font-semibold' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg font-bold text-gray-500">#{{ $index + 1 }}</span>
                                        @if($index < 3)
                                            <span class="text-lg">{{ $index === 0 ? '🥇' : ($index === 1 ? '🥈' : '🥉') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $avatarFrame = $lbUser->activeFrame;
                                            $avatarBorder = 'border-2 border-gray-200';
                                            if ($avatarFrame) {
                                                if ($avatarFrame->rarity === 'legendary') $avatarBorder = 'border-4 border-yellow-400 shadow-lg shadow-yellow-400/40';
                                                elseif ($avatarFrame->rarity === 'epic') $avatarBorder = 'border-3 border-purple-500 shadow-md shadow-purple-500/30';
                                                elseif ($avatarFrame->rarity === 'rare') $avatarBorder = 'border-2 border-blue-400';
                                            }
                                        @endphp
                                        @if($lbUser->avatar)
                                            <img src="{{ asset('storage/' . $lbUser->avatar) }}" class="w-10 h-10 rounded-full object-cover {{ $avatarBorder }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold {{ $avatarBorder }}">
                                                {{ substr($lbUser->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold {{ $lbUser->id == Auth::id() ? 'text-green-600' : 'text-gray-800' }}">
                                                {{ $lbUser->name }}
                                                @if($lbUser->id == Auth::id())
                                                    <span class="text-xs font-semibold text-green-600">(Kamu)</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $lbUser->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $lbUser->level_color }} text-white">
                                        {{ $lbUser->level_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-base font-bold text-green-600">{{ number_format($lbUser->xp) }} XP</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
