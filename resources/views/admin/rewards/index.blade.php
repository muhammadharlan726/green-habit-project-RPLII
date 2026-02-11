<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🎁 Kelola Rewards</h1>
            <p class="text-sm text-gray-500">Tambah, edit, dan nonaktifkan hadiah</p>
        </div>
        <a href="{{ route('admin.rewards.create') }}" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition">+ Tambah Reward</a>
    </div>

    @if($rewards->isEmpty())
        <div class="bg-white rounded-xl shadow p-10 text-center">
            <div class="text-5xl mb-3">🛍️</div>
            <p class="text-gray-700 font-semibold">Belum ada hadiah.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hadiah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cost</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach($rewards as $reward)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl">{{ $reward->icon ?? '🎁' }}</span>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $reward->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($reward->description, 80) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $reward->cost }} XP</td>
                            <td class="px-4 py-3">{{ $reward->stock }}</td>
                            <td class="px-4 py-3">
                                @if($reward->is_active)
                                    <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded">Aktif</span>
                                @else
                                    <span class="text-xs font-bold px-2 py-1 bg-gray-200 text-gray-600 rounded">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.rewards.edit', $reward) }}" class="text-blue-600 hover:underline text-xs font-semibold">Edit</a>
                                <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST" class="inline" onsubmit="return confirm('Hapus hadiah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $rewards->links() }}</div>
    @endif
</x-admin-layout>
