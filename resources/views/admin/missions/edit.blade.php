<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">✏️ Edit Mission</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Update informasi misi</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <form action="{{ route('admin.missions.update', $mission) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Mission Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $mission->title) }}" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Description *</label>
                    <textarea id="description" name="description" rows="6" required class="w-full px-3 sm:px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm font-sans resize-none @error('description') border-red-500 @enderror">{{ old('description', $mission->description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">💡 Tekan Enter untuk membuat baris baru</p>
                    @error('description')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Points Reward -->
                <div>
                    <label for="points_reward" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">XP Reward *</label>
                    <input type="number" id="points_reward" name="points_reward" value="{{ old('points_reward', $mission->points_reward) }}" min="1" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('points_reward') border-red-500 @enderror">
                    @error('points_reward')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Frequency -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Frequency (Frekuensi Misi) *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center gap-3 p-4 rounded-lg border-2 cursor-pointer transition-all duration-200 hover:border-green-400 has-[:checked]:border-green-500 has-[:checked]:bg-green-50 has-[:checked]:shadow-md">
                            <input type="radio" name="frequency" value="daily" {{ old('frequency', $mission->frequency) === 'daily' ? 'checked' : '' }} required class="w-5 h-5 text-green-600 focus:ring-2 focus:ring-green-500">
                            <div>
                                <p class="text-sm font-bold text-gray-800">📅 Harian (Daily)</p>
                                <p class="text-xs text-gray-500">Dapat diambil setiap hari</p>
                            </div>
                        </label>
                        <label class="relative flex items-center gap-3 p-4 rounded-lg border-2 cursor-pointer transition-all duration-200 hover:border-blue-400 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:shadow-md">
                            <input type="radio" name="frequency" value="weekly" {{ old('frequency', $mission->frequency) === 'weekly' ? 'checked' : '' }} required class="w-5 h-5 text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-bold text-gray-800">📆 Mingguan (Weekly)</p>
                                <p class="text-xs text-gray-500">Dapat diambil per minggu</p>
                            </div>
                        </label>
                    </div>
                    @error('frequency')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requires Evidence -->
                <div class="flex items-start gap-3 p-3 sm:p-4 rounded-lg bg-gray-50 border">
                    <input type="checkbox" id="requires_evidence" name="requires_evidence" value="1" @if(old('requires_evidence', $mission->requires_evidence)) checked @endif class="mt-1 w-4 h-4 sm:w-5 sm:h-5 rounded text-green-600 focus:ring-2 focus:ring-green-200">
                    <div>
                        <label for="requires_evidence" class="text-sm sm:text-base font-semibold text-gray-700">Requires Evidence (Photo/Proof)</label>
                        <p class="text-xs text-gray-500 mt-1">If checked, users must submit proof before completing this mission</p>
                    </div>
                </div>

                <!-- Mission Info -->
                <div class="p-3 sm:p-4 rounded-lg bg-blue-50 border border-blue-200 space-y-2">
                    <p class="text-xs sm:text-sm text-blue-800"><strong>Created:</strong> {{ $mission->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-xs sm:text-sm text-blue-800"><strong>Last Updated:</strong> {{ $mission->updated_at->format('d M Y, H:i') }}</p>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm sm:text-base">
                        💾 Save Changes
                    </button>
                    <a href="{{ route('admin.missions.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-center text-sm sm:text-base">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
