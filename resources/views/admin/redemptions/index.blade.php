<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">🎁 Pending Redeem</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Approve/Reject permintaan penukaran hadiah</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($pendingRedemptions->isEmpty())
        <div class="bg-white rounded-xl shadow p-10 text-center">
            <div class="text-5xl mb-3">✨</div>
            <p class="text-gray-700 font-semibold">Tidak ada permintaan penukaran.</p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($pendingRedemptions as $redeem)
                <div class="bg-white rounded-xl shadow border-l-4 border-yellow-500 p-5">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-bold text-gray-800">{{ $redeem->reward->name }}</span>
                                <span class="text-[10px] px-2 py-1 bg-yellow-100 text-yellow-800 rounded border border-yellow-200">{{ $redeem->reward->cost }} XP</span>
                            </div>
                            <p class="text-xs text-gray-600">Peminta: <span class="font-semibold">{{ $redeem->user->name }}</span> ({{ $redeem->user->email }})</p>
                            <p class="text-xs text-gray-500">Diajukan: {{ $redeem->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-xs text-gray-500">Stok tersisa: <span class="font-bold text-gray-800">{{ $redeem->reward->stock }}</span></div>
                    </div>

                    <div class="mt-4 flex flex-col sm:flex-row gap-3">
                        <form method="POST" action="{{ route('admin.redemptions.approve', $redeem->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition">
                                ✅ Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.redemptions.reject', $redeem->id) }}" class="flex-1">
                            @csrf
                            <textarea name="admin_note" rows="2" placeholder="Alasan penolakan (opsional)..." class="w-full mb-2 px-3 py-2 text-xs border border-gray-300 rounded"></textarea>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition" onclick="return confirm('Tolak permintaan ini?');">
                                ❌ Reject & Refund XP
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $pendingRedemptions->links() }}
        </div>
    @endif
</x-admin-layout>
