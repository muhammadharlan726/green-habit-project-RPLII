<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">✏️ Edit Guide</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Perbarui informasi panduan</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-4 sm:p-8">
        <form method="POST" action="{{ route('admin.guides.update', $guide) }}" class="max-w-2xl">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $guide->title) }}" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-xs sm:text-sm" required>
                @error('title')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="8" class="w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-xs sm:text-sm font-sans resize-none" required>{{ old('description', $guide->description) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">💡 Tekan Enter untuk membuat baris baru</p>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icon (Emoji) -->
            <div class="mb-6">
                <label for="icon" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Icon (Emoji)</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $guide->icon) }}" maxlength="10" class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-xs sm:text-sm" required>
                @error('icon')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm sm:text-base">
                    ✅ Update Guide
                </button>
                <a href="{{ route('admin.guides.index') }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition text-center text-sm sm:text-base">
                    ❌ Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
