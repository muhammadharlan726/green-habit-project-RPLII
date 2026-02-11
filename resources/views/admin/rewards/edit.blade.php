<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Reward</h1>
            <p class="text-sm text-gray-500">Perbarui detail hadiah</p>
        </div>
        <a href="{{ route('admin.rewards.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.rewards.update', $reward) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Reward</label>
                <input type="text" name="name" value="{{ old('name', $reward->name) }}" class="w-full border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 font-sans resize-none text-sm">{{ old('description', $reward->description) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">💡 Tekan Enter untuk membuat baris baru</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cost (XP)</label>
                    <input type="number" name="cost" value="{{ old('cost', $reward->cost) }}" class="w-full border-gray-300 rounded-lg" required min="1">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $reward->stock) }}" class="w-full border-gray-300 rounded-lg" required min="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Icon/Emoji</label>
                    <input type="text" name="icon" value="{{ old('icon', $reward->icon) }}" class="w-full border-gray-300 rounded-lg" maxlength="20">
                </div>
            </div>

            {{-- Frame Cosmetic Properties --}}
            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-sm font-bold text-gray-700 mb-3">🎨 Cosmetic Frame Properties</h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rarity</label>
                    <select name="rarity" class="w-full border-gray-300 rounded-lg">
                        <option value="common" {{ old('rarity', $reward->rarity) === 'common' ? 'selected' : '' }}>Common (Umum) - Hijau</option>
                        <option value="rare" {{ old('rarity', $reward->rarity) === 'rare' ? 'selected' : '' }}>Rare (Langka) - Biru</option>
                        <option value="epic" {{ old('rarity', $reward->rarity) === 'epic' ? 'selected' : '' }}>Epic (Epik) - Ungu</option>
                        <option value="legendary" {{ old('rarity', $reward->rarity) === 'legendary' ? 'selected' : '' }}>Legendary (Legendaris) - Kuning Emas</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">✨ Warna border dan glow otomatis mengikuti rarity</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300" {{ old('is_active', $reward->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-700">Aktif</label>
            </div>
            <div class="pt-2">
                <button type="submit" class="px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>
