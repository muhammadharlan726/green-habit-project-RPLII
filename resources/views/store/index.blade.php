<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-green-200 via-white to-green-200 bg-clip-text text-transparent leading-tight flex items-center gap-3">
                <span class="inline-block animate-pulse-slow">🛒</span>
                Shop
            </h2>
            <div class="flex items-center gap-2 text-sm font-bold">
                <span class="text-green-200">Poin kamu</span>
                <span class="px-4 py-2 rounded-full bg-gradient-to-r from-green-500 to-green-600 text-white border-2 border-green-400 shadow-lg hover:shadow-xl transition-all duration-300">{{ number_format($user->xp) }} XP</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-900 via-green-900 to-emerald-900 min-h-screen relative overflow-hidden" x-data="{ showConfirm: false, selectedReward: null, confirmRedeem(reward) { this.selectedReward = reward; this.showConfirm = true; } }">
        <!-- Animated Background Blobs -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-green-700 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-600 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-teal-700 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">

            @if($rewards->isEmpty())
                <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-xl p-10 text-center border-2 border-green-100 hover:shadow-2xl transition-all duration-300">
                    <div class="text-6xl mb-3 animate-pulse-slow">🛍️</div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent mb-2">Belum ada hadiah</h3>
                    <p class="text-gray-600">Admin belum menambahkan hadiah di toko.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($rewards as $reward)
                        @php
                            $latest = $latestRedemptions[$reward->id] ?? null;
                            $status = $latest?->status;
                        @endphp
                        <div class="group bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-400 flex flex-col overflow-hidden hover:-translate-y-2">
                            <div class="p-6 flex-1 flex flex-col items-center text-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center text-3xl shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                                    {{ $reward->icon ?? '🎁' }}
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-base font-bold bg-gradient-to-r from-gray-800 to-green-700 bg-clip-text text-transparent">{{ $reward->name }}</h3>
                                    <p class="text-sm text-gray-500 line-clamp-3 whitespace-pre-wrap">{{ $reward->description }}</p>
                                </div>
                                <div class="text-transparent bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text font-extrabold text-xl">{{ number_format($reward->cost) }} Poin</div>
                                <div class="text-xs text-gray-500">Stok: <span class="font-semibold">{{ $reward->stock }}</span></div>

                                @if($status === 'pending')
                                    <div class="px-3 py-2 rounded-lg bg-yellow-50 border border-yellow-200 text-[12px] text-yellow-700 font-semibold w-full">⏳ Menunggu persetujuan</div>
                                @elseif($status === 'approved')
                                    <div class="px-3 py-2 rounded-lg bg-green-50 border border-green-200 text-[12px] text-green-700 font-semibold w-full">✅ Terakhir disetujui</div>
                                @elseif($status === 'rejected')
                                    <div class="px-3 py-2 rounded-lg bg-red-50 border border-red-200 text-[12px] text-red-700 font-semibold w-full">
                                        ❌ Ditolak admin
                                        @if($latest?->admin_note)
                                            <div class="text-[11px] text-red-600 mt-1">Alasan: {{ $latest->admin_note }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 border-t border-gray-100 bg-slate-50">
                                @if($reward->stock <= 0)
                                    <button class="w-full bg-gray-200 text-gray-500 text-sm font-bold py-2.5 px-4 rounded-xl cursor-not-allowed">Stok Habis</button>
                                @elseif($status === 'pending')
                                    <button class="w-full bg-yellow-200 text-yellow-800 text-sm font-bold py-2.5 px-4 rounded-xl cursor-not-allowed">Menunggu Persetujuan</button>
                                @else
                                    @if($user->xp < $reward->cost)
                                        <button class="w-full bg-gray-200 text-gray-500 text-sm font-bold py-2.5 px-4 rounded-xl cursor-not-allowed">Poin Tidak Cukup</button>
                                    @else
                                        <form id="redeemForm{{ $reward->id }}" method="POST" action="{{ route('store.redeem', $reward) }}" style="display: none;">
                                            @csrf
                                        </form>
                                        <button type="button" @click="confirmRedeem({ id: {{ $reward->id }}, name: '{{ addslashes($reward->name) }}', cost: {{ $reward->cost }}, icon: '{{ $reward->icon ?? '🎁' }}' })" class="w-full bg-gradient-to-r from-gray-900 to-gray-800 hover:from-gray-800 hover:to-gray-700 text-white text-sm font-bold py-2.5 px-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl active:scale-95">
                                            Tukar Sekarang
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $rewards->links() }}
                </div>
            @endif

            {{-- Confirmation Modal --}}
                <div x-show="showConfirm" 
                     x-cloak
                     @click.self="showConfirm = false"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden"
                         x-show="showConfirm"
                         @click.stop
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90">
                        
                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-2xl">
                                    <span x-text="selectedReward?.icon || '🎁'"></span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">Konfirmasi Penukaran</h3>
                                    <p class="text-sm text-green-100">Pastikan poin kamu cukup</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="bg-slate-50 rounded-xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Hadiah</span>
                                    <span class="font-bold text-gray-800" x-text="selectedReward?.name"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Biaya</span>
                                    <span class="font-bold text-red-600" x-text="(selectedReward?.cost || 0) + ' XP'"></span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Poin Saat Ini</span>
                                        <span class="font-bold text-green-600">{{ $user->xp }} XP</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Sisa Poin</span>
                                        <span class="font-bold text-blue-600" x-text="({{ $user->xp }} - (selectedReward?.cost || 0)) + ' XP'"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 flex items-start gap-2">
                                <span class="text-yellow-600 text-lg">⚠️</span>
                                <p class="text-xs text-yellow-800">Penukaran akan diproses oleh admin. Harap tunggu konfirmasi sebelum hadiah dikirim.</p>
                            </div>
                        </div>

                        <div class="p-6 pt-0 flex gap-3">
                            <button type="button" @click="showConfirm = false" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl transition-all duration-300 active:scale-95">
                                Batal
                            </button>
                            <button type="button" @click="document.getElementById('redeemForm' + selectedReward?.id).submit()" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl active:scale-95">
                                Ya, Tukar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
