<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            🎨 {{ __('Profile Frame Customization') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Pilih frame profil dari koleksi yang telah kamu unlock di store. Frame akan ditampilkan di dashboard dan leaderboard.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-frame') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-4">
            @php
                $unlockedFrames = Auth::user()->unlockedFrames()->get();
                $activeFrameId = Auth::user()->active_profile_frame_id;
            @endphp

            @if($unlockedFrames->isEmpty())
                <div class="p-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 text-center">
                    <div class="text-4xl mb-2">🔒</div>
                    <p class="text-gray-600 font-semibold">Kamu belum memiliki frame apapun</p>
                    <p class="text-sm text-gray-500 mt-1">Beli frame di Store menggunakan XP!</p>
                    <a href="{{ route('store.index') }}" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                        🛒 Kunjungi Store
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Default Frame --}}
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="active_profile_frame_id" value="" {{ $activeFrameId === null ? 'checked' : '' }} class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                            <div class="aspect-square rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 border-2 border-gray-300 flex items-center justify-center mb-3">
                                <span class="text-3xl">👤</span>
                            </div>
                            <p class="font-bold text-center text-gray-800">Default</p>
                            <p class="text-xs text-center text-gray-500">Tidak ada frame</p>
                        </div>
                        <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full w-6 h-6 items-center justify-center hidden peer-checked:flex">
                            ✓
                        </div>
                    </label>

                    {{-- Unlocked Frames --}}
                    @foreach($unlockedFrames as $redemption)
                        @php $frame = $redemption->reward; @endphp
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="active_profile_frame_id" value="{{ $frame->id }}" {{ $activeFrameId == $frame->id ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                                <div class="aspect-square rounded-lg bg-gradient-to-br from-white to-gray-50 {{ $frame->frame_border_class }} {{ $frame->frame_glow_class }} flex items-center justify-center mb-3 relative overflow-hidden">
                                    <span class="text-3xl">{{ $frame->icon ?? '🎁' }}</span>
                                    @if($frame->rarity)
                                        <span class="absolute top-1 right-1 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase
                                            {{ $frame->rarity === 'legendary' ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white' : '' }}
                                            {{ $frame->rarity === 'epic' ? 'bg-gradient-to-r from-purple-500 to-pink-600 text-white' : '' }}
                                            {{ $frame->rarity === 'rare' ? 'bg-gradient-to-r from-blue-400 to-cyan-500 text-white' : '' }}
                                            {{ $frame->rarity === 'common' ? 'bg-gray-400 text-white' : '' }}">
                                            {{ $frame->rarity }}
                                        </span>
                                    @endif
                                </div>
                                <p class="font-bold text-center text-gray-800 text-sm truncate">{{ $frame->name }}</p>
                                <p class="text-xs text-center text-gray-500">{{ ucfirst($frame->rarity ?? 'common') }}</p>
                            </div>
                            <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full w-6 h-6 items-center justify-center hidden peer-checked:flex z-10">
                                ✓
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Frame') }}</x-primary-button>

            @if (session('frame_updated') === 'frame-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Frame berhasil diubah!') }}</p>
            @endif
        </div>
    </form>
</section>
